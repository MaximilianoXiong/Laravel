@extends('layouts.todo')

@section('contenido')
    @if (session('estadoCompra'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('estadoCompra') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif


    <div class="row">
        <div class="col">
            <div class="card">
                <h1>Productos</h1>
                @if (isset($productos) && count($productos) > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0 table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Código</th>
                                        <th>Nombre</th>
                                        <th>Precio</th>
                                        <th>Stock</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($productos as $p)
                                        <tr>
                                            <td>{{ $p->codigo }}</td>
                                            <td>{{ $p->nombre }}</td>
                                            <td>${{ $p->precio }}</td>
                                            <td>{{ $p->stock }}</td>
                                            <form action="" method="POST">
                                                @csrf
                                                <td>
                                                    <input type="hidden" name="producto_id" value="{{ $p->id }}">
                                                    <label>Cantidad:</label>
                                                    <input type="number" name="cantidad" value="0" max="{{ $p->stock }} " min="1"
                                                        required>
                                                </td>
                                                <td>
                                                    <button type="submit" name="accion" value="Agregar" class="btn btn-success">Agregar
                                                        al
                                                        carrito</button>
                                                </td>
                                            </form>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                <h6>No hay nada</h6>
            @endif
        </div>
        <div class="col">
            <div class="card">
                <h1>Carrito</h1>
                <div class="table-responsive">
                    <table class="table table-bordered mb-0 table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Nombre</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                                <th>Total</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $carrito = session()->get('carrito', []);
                            @endphp
                            @if($carrito == null)
                                <tr>
                                    <td colspan="5" style="text-align: center;">Sin productos</td>
                                </tr>
                            @else
                                @foreach($carrito as $item)
                                    <tr>
                                        <td>{{ $item['producto']['nombre'] }}</td>
                                        <td>${{ number_format($item['producto']['precio'], 2) }}</td>
                                        <td>{{ $item['cantidad'] }}</td>
                                        <td>${{ number_format($item['producto']['precio'] * $item['cantidad'], 2) }}</td>
                                        <td>
                                            <form action="" method="POST">
                                                @csrf
                                                <input type="hidden" name="producto_id" value="{{ $item['producto']['id'] }}">
                                                <button type="submit" name="accion" value="Quitar" class="btn btn-success">Quitar
                                                    1</button>
                                                <button type="submit" name="accion" value="QuitarTodo"
                                                    class="btn btn-success">Quitar
                                                    todo</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <form action="/Comprar/compra" method="post">
                    @csrf
                    <input type="submit" value="Realizar compra">
                </form>
            </div>
        </div>
    </div>

@endsection