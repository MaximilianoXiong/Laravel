<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ComprasRealizadas;

class ComprasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //esto quiere decir, "trae compras, con, la lista de productos comprados y los productos"
        //porque compras realizadas tiene una serie de productos comprados, productos comprados tiene datos de productos
        $compras = ComprasRealizadas::with('productosComprados.producto')->get();
        return view('ComprasRealizadas', ['compras' => $compras]);
    }

    public function filtrar(Request $request)
    {
        //esto quiere decir, "esto tiene productos comprados y prodcutos comprados tiene productos"
        //si pusiera 'productos.tienda.lugares', esto significa, productos tiene tienda (relacion) y tienda tiene lugares (relacion)

        $query = ComprasRealizadas::with('productosComprados.producto');

        //////////////POR PRODUCTOS

        if ($request->filled('nombre_producto')) { //filtro por nombre del prod
            $productoNombre = $request->input('producto');
            $query->whereHas('productosComprados.producto', function ($q) use ($productoNombre) {
                $q->where('nombre', 'like', '%' . $productoNombre . '%');
            });
        }

        if ($request->filled('codigo_producto')) { //filtro por codigo del prod
            $productoCodigo = $request->input('codigo_producto');
            $query->whereHas('productosComprados.producto', function ($q) use ($productoCodigo) {
                $q->where('codigo', 'like', '%' . $productoCodigo . '%');
            });
        }

        //////////////POR PRODUCTOS COMPRADOS

        if ($request->filled('cantidad')) { //filtro por cantidad de productos comprados
            $cantidad = $request->input('cantidad');
            $query->whereHas('productosComprados', function ($q) use ($cantidad) {
                $q->where('cantidad', 'like', '%' . $cantidad . '%');
            });
            //whereHas es "donde..." en este caso es, "donde productosComprados (el modelo de tabla) cumpla esta funcion", el
            //use es para incorporar variables externas a la funcion
            //el where es como si hicieras una consulta individual dentro del modelo "interno" 
        }

        if ($request->filled('precio_total')) { //filtro por precio total productos comprados
            $precioTotal = $request->input('precio_total');
            $query->whereHas('productosComprados', function ($q) use ($precioTotal) {
                $q->where('precio', 'like', '%' . $precioTotal . '%');
            });
        }

        /////////////POR COMPRAS

        if ($request->filled('fecha')) { //filtro por fecha
            $query->whereDate('fecha', $request->input('fecha'));
        }


        $compras = $query->get();
        return view('ComprasRealizadas', ['compras' => $compras]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
