@extends('layouts.todo')

@section('contenido')
    @if (isset($producto))
        <div class="row">
            {{-- Formulario de modificación --}}
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-header">
                        <h5>Modificar producto</h5>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="codigo" class="form-label">Código</label>
                                <input type="text" name="codigo" value="{{ $producto->codigo }}" class="form-control"
                                    id="codigo">
                            </div>
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" name="nombre" value="{{ $producto->nombre }}" class="form-control"
                                    id="nombre">
                            </div>
                            <div class="mb-3">
                                <label for="precio" class="form-label">Precio</label>
                                <input type="text" name="precio" value="{{ $producto->precio }}" class="form-control"
                                    id="precio">
                            </div>
                            <div class="mb-3">
                                <label for="stock" class="form-label">Stock</label>
                                <input type="text" name="stock" value="{{ $producto->stock }}" class="form-control" id="stock">
                            </div>
                            <div class="mb-3">
                                <label for="stock_min" class="form-label">Stock mínimo</label>
                                <input type="text" name="stock_min" value="{{ $producto->stock_min }}" class="form-control"
                                    id="stock_min">
                            </div>
                            <div class="mb-3">
                                <label for="tipo_oferta" class="form-label">Tipo de oferta (%)</label>
                                <input type="text" name="tipo_oferta" value="{{ $producto->tipo_oferta }}" class="form-control"
                                    id="tipo_oferta">
                            </div>
                            <div class="mb-3">
                                <label for="oferta" class="form-label">Oferta (%)</label>
                                <input type="text" name="oferta" value="{{ $producto->oferta }}" class="form-control"
                                    id="oferta">
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-warning">Modificar producto</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Estado actual --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-light">
                        <h5>Estado actual del producto</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item"><strong>Código:</strong> {{ $producto->codigo }}</li>
                            <li class="list-group-item"><strong>Nombre:</strong> {{ $producto->nombre }}</li>
                            <li class="list-group-item"><strong>Precio:</strong> ${{ $producto->precio }}</li>
                            <li class="list-group-item"><strong>Stock:</strong> {{ $producto->stock }}</li>
                            <li class="list-group-item"><strong>Stock mínimo:</strong> {{ $producto->stock_min }}</li>
                            <li class="list-group-item"><strong>Tipo de oferta:</strong>
                                {{ $producto->tipo_oferta ?? 'Sin tipo de oferta' }}</li>
                            <li class="list-group-item"><strong>Oferta:</strong> {{ $producto->oferta ?? 'Sin oferta' }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-danger">
            <h4>No se encontró el producto.</h4>
        </div>
    @endif
@endsection