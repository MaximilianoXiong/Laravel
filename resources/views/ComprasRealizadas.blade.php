@extends('layouts.todo')

@section('contenido')
    <div class="table-responsive">
        <table class="table table-bordered mb-0 table-hover">
            <thead class="table-light">
                <tr>
                    <th>Fecha</th>
                    <th>Productos</th>
                </tr>
            </thead>
            <tbody>
                <tr>

                </tr>
                @if(isset($compras) && count($compras) > 0)
                    @foreach ($compras as $compra)
                        <tr>
                            <td>{{ $compra->fecha }}</td>
                            <td>
                                <ul>
                                    @foreach ($compra->productosComprados as $producto_comprado)
                                        <li>
                                            Nombre: {{ $producto_comprado->producto->nombre }} <br>
                                            Cantidad: {{ $producto_comprado->cantidad }} <br>
                                            Precio unidad: {{ $producto_comprado->precio }}<br>
                                            Precio total: {{ $producto_comprado->cantidad * $producto_comprado->precio }}<br>
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                    @endforeach

                @else
                    <td colspan="2">no hay compras</td>
                @endif
            </tbody>
        </table>
    </div>
@endsection