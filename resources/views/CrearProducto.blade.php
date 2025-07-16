@extends('layouts.todo')

@section('contenido')
    <div class="card">
        <div class="card-header">
            <h5>Agregar nuevo producto</h5>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-warning">
                    {{ session('error') }}
                </div>
            @endif

            <form action="" method="POST">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="codigo" class="form-label">Código</label>
                        <input type="text" name="codigo" class="form-control" id="codigo" required>
                    </div>
                    <div class="col-md-4">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control" id="nombre" required>
                    </div>
                    <div class="col-md-4">
                        <label for="precio" class="form-label">Precio</label>
                        <input type="text" name="precio" class="form-control" id="precio" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="stock" class="form-label">Stock</label>
                        <input type="text" name="stock" class="form-control" id="stock" required>
                    </div>
                    <div class="col-md-4">
                        <label for="stock_min" class="form-label">Stock mínimo</label>
                        <input type="text" name="stock_min" class="form-control" id="stock_min" required>
                    </div>
                    <div class="col-md-4">
                        <label for="tipo_oferta" class="form-label">Tipo de oferta</label>
                        <input type="text" name="tipo_oferta" class="form-control" id="tipo_oferta">
                    </div>

                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="oferta" class="form-label">Oferta (%)</label>
                        <input type="text" name="oferta" class="form-control" id="oferta">
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Guardar producto</button>
                </div>
            </form>
        </div>
    </div>
@endsection