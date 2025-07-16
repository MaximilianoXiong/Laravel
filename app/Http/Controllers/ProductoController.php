<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Productos;
use App\Models\ComprasRealizadas;
use App\Models\ProductosComprados;

class ProductoController extends Controller
{
    public function ajaxIndex()
    {
        return view('pruebas');
    }
    public function pruebasAjax(Request $request)
    {
        $buscado = $request->input('nombre');
        $query = Productos::where('nombre', $buscado)->get();
        return response()->json($query);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Productos::all();
        return view('ListarProductos', ['productos' => $productos]);
    }

    public function filter(Request $request)
    {
        $query = Productos::query();
        $camposFiltrables = ['nombre', 'codigo', 'stock', 'stock_min', 'precio', 'oferta', 'tipo_oferta'];

        //esto solo filtra los campos mencionados arriba (no incluye el filtro para el rengo del stock, se hace mas abajo)
        foreach ($request->only($camposFiltrables) as $campo => $valor) {
            if (!empty($valor)) {
                if (in_array($campo, ['nombre', 'codigo', 'tipo_oferta'])) {
                    $query->whereRaw("LOWER($campo) LIKE ?", ['%' . strtolower($valor) . '%']);
                } else {
                    $query->where($campo, $valor);
                }
            }
        }

        $stockEstado = $request->input('stock_estado');
        $X = 3; // x es que tan cerca del minimo

        if (!empty($stockEstado)) {
            switch ($stockEstado) {
                case 'bajo':
                    $query->whereColumn('stock', '<', 'stock_min');
                    break;
                case 'minimo':
                    $query->whereColumn('stock', '=', 'stock_min');
                    break;
                case 'cerca':
                    $query->whereRaw('stock > stock_min AND stock <= stock_min + ?', [$X]);
                    break;
            }
        }

        return view('ListarProductos', ['productos' => $query->get()]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('CrearProducto');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //cambia las comas por puntos
        $request->merge([
            'precio' => str_replace(',', '.', $request->precio),
            'oferta' => str_replace(',', '.', $request->oferta),
        ]);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|max:50',
            'tipo_oferta' => 'nullable|string|max:255',
            'stock' => 'required|integer|min:0',
            'stock_min' => 'required|integer|min:0',
            'precio' => 'required|numeric|min:0',
            'oferta' => 'nullable|numeric',
        ]);

        // Crear nuevo producto
        $producto = new Productos();
        $campos = ['nombre', 'codigo', 'stock', 'stock_min', 'precio', 'oferta', 'tipo_oferta'];
        foreach ($request->only($campos) as $campo => $valor) {
            if ($valor === '') {
                $producto->$campo = null;
            } else {
                $producto->$campo = $valor;
            }
        }

        if ($producto->save()) {
            return redirect('/')->with('estadoGuardado', 'Producto creado correctamente');
        } else {
            return back()->with('error', 'No se pudo guardar el producto');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $prodMod = Productos::findOrFail($id);
        return view('ModificarProductos', ['producto' => $prodMod]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $producto = Productos::findOrFail($id);
        $camposFiltrables = ['nombre', 'codigo', 'stock', 'stock_min', 'precio', 'oferta', 'tipo_oferta'];
        foreach ($request->only($camposFiltrables) as $campo => $valor) {
            if (!empty($valor)) {
                $producto->$campo = $valor;
            }
        }
        if ($producto->save()) { //el save hace un update si existe su pk, si no hace un insert
            return redirect('/')->with('estadoMod', "El producto fue modificado de forma exitosa"); //redirect tambien ejecuta su controller especifico
        } else {
            return redirect('/')->with('estadoMod', "Fallo al modificar el producto"); //estado es una variable dentro de session
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $producto = Productos::findOrFail($id);
        if ($producto->delete()) {
            return redirect('/')->with('estadoDel', "Producto fue borrado de forma exitosa"); //estado es una variable dentro de session
        } else {
            return redirect('/')->with('estadoDel', 'Fallo al intentar borrar el producto'); //estado es una variable dentro de session
        }
    }

    public function mostrarActualizar()
    {
        $productos = Productos::all();
        return view('ActualizarInventario', ['productos' => $productos]);
    }

    public function actualizarInventario(Request $request)
    {
        $aModificar = $request->input('modificar', []); // array de IDs marcados

        foreach ($aModificar as $id) {
            // 2. Validar existencia
            $producto = Productos::find($id);
            if ($producto) {
                // 3. Obtener los nuevos valores enviados
                if ($request->has("stock.$id")) {
                    $producto->stock = $request->input("stock.$id");
                }
                if ($request->has("stock_min.$id")) {
                    $producto->stock_min = $request->input("stock_min.$id");
                }
                $producto->save();
            }
        }
        return redirect('/')->with('estadoActualizarStock', 'Stock actualizado');
    }

    public function mostrarCarrito()
    {
        $productos = Productos::all();
        return view('CarritoCompras', ['productos' => $productos]);
    }

    public function manejarCarrito(Request $request)
    {
        //esto recibe un id de un producto junto a su cantidad y lo guarda en session, para ir acumulando
        $id = $request->input('producto_id');
        $cant = $request->input('cantidad');
        $accion = $request->input('accion');

        $carrito = session()->get('carrito', []); //obtenemos todos los datos del carrito actual

        if ($accion == 'Agregar') { //accion es el name del boton submit, que deberia tener el valor Agregar y Quitar
            $producto = Productos::findOrFail($id);
            if (empty($carrito[$id])) {
                $carrito[$id]['producto'] = [
                    'id' => $producto->id,
                    'nombre' => $producto->nombre,
                    'precio' => $producto->precio
                ];
                $carrito[$id]['cantidad'] = $cant;
            } else {
                $carrito[$id]['cantidad'] = $carrito[$id]['cantidad'] + $cant;
            }
        } else if ($accion == 'QuitarTodo') {
            //quitar del carrito
            unset($carrito[$id]);
        } else {
            //quitar solo 1 (no todo)
            $carrito[$id]['cantidad'] = $carrito[$id]['cantidad'] - 1;
            if ($carrito[$id]['cantidad'] <= 0) {
                unset($carrito[$id]);
            }
        }

        session()->put('carrito', $carrito); //reemplazas el carrito anterior por el nuevo
        return redirect('/Comprar');
    }

    public function filtrarCarrito()
    {
        //aqui se filtran los datos para agregar en el carrito
    }

    public function subirCarrito()
    {
        //aqui debo limpiar el carrito de session, una vez que lo mande
        if (session()->has('carrito')) { //si existe el carrito y no es null
            $carrito = session()->get('carrito', []); //obtenemos todos los datos del carrito actual

            //creo una nueva compra
            $nuevaCompra = new ComprasRealizadas();
            $nuevaCompra->save(); //esto crea una id y una fecha para dicha compra

            //deberia ver como "revertir tooodooo en caso de que 1 falle"
            $ok = true;
            foreach ($carrito as $car) {
                $productoComprado = new ProductosComprados();
                $productoComprado->id_producto = $car['producto']['id'];
                $productoComprado->id_compra = $nuevaCompra->id; //como se guardo una nueva compra, puedo obtener lo guardado asi
                $productoComprado->cantidad = $car['cantidad'];
                $productoComprado->precio = $car['producto']['precio'] * $car['cantidad'];
                if (!$productoComprado->save()) {
                    $ok = false;
                    break;
                }
                $productoDb = Productos::find($car['producto']['id']); //buscas el producto
                $productoDb->stock = $productoDb->stock - $car['cantidad']; //le reduces el stock
                $productoDb->save();
            }

            if ($ok) {
                session()->put('carrito'); //limpiamos, put "inserta", en este caso, nada
                return redirect('/Comprar')->with('estadoCompra', 'Compra realizada');
            } else {
                return redirect('/Comprar')->with('estadoCompra', 'Error al comprar');
            }
        } else {
            return redirect('/Comprar')->with('estadoCompra', 'Error al comprar, no hay productos seleccionados');
        }
    }

}
