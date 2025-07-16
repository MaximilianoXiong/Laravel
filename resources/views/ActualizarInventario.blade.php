@extends('layouts.todo')

@section('contenido')
    <div class="card">
        <div class="card-header">
            <h5>Listado de productos</h5>
        </div>
        <div class="card-body p-0">
            @if (isset($productos) && count($productos) > 0)
                <form action="" method="post">
                    @csrf
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0 table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th></th>
                                    <th>Código</th>
                                    <th>Nombre</th>
                                    <th>Precio</th>
                                    <th>Stock</th>
                                    <th>Stock mínimo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productos as $p)
                                    <tr>
                                        <td><input type="checkbox" name="modificar[]" value="{{ $p->id }}" id=""></td>
                                        <td>{{ $p->codigo }}</td>
                                        <td>{{ $p->nombre }}</td>
                                        <td>{{ $p->precio }}</td>
                                        <td><input type="text" name="stock[{{ $p->id }}]" value="{{ $p->stock }}"></td>
                                        <td><input type="text" name="stock_min[{{ $p->id }}]" value="{{ $p->stock_min }}"></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center mb-2 mt-2">
                        <input type="submit" class="btn btn-success" value="Actualizar">
                    </div>
                </form>
            @else
                <div class="p-4">
                    <p class="text-center text-muted">Aún no hay productos disponibles.</p>
                </div>
            @endif
        </div>
    </div>
@endsection