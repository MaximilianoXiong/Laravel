@extends('layouts.todo')

@section('contenido')
    <div class="container mt-4">

        {{-- Mensajes de sesión --}}
        @if (session('estadoMod'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('estadoMod') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif

        @if (session('estadoDel'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                {{ session('estadoDel') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif

        @if (session('estadoActualizarStock'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('estadoActualizarStock') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif

        {{-- Filtro de productos --}}
        <div class="card mb-4">
            <div class="card-header text-center">
                <h5>Filtrar productos</h5>
            </div>
            <div class="card-body">
                <form action="" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="codigo" class="form-label">Código</label>
                            <input type="text" name="codigo" class="form-control" id="codigo">
                        </div>
                        <div class="col-md-4">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" name="nombre" class="form-control" id="nombre">
                        </div>
                        <div class="col-md-4">
                            <label for="precio" class="form-label">Precio</label>
                            <input type="text" name="precio" class="form-control" id="precio">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="stock" class="form-label">Stock actual</label>
                            <input type="text" name="stock" class="form-control" id="stock">
                        </div>
                        <div class="col-md-4">
                            <label for="stock_min" class="form-label">Stock mínimo</label>
                            <input type="text" name="stock_min" class="form-control" id="stock_min">
                        </div>
                        <div class="col-md-4">
                            <label for="oferta" class="form-label">Oferta</label>
                            <input type="text" name="oferta" class="form-control" id="oferta">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="stock_estado" class="form-label">Estado de stock: </label>
                            <select name="stock_estado">
                                <option value="">----</option>
                                <option value="bajo">Por debajo del stock mínimo</option>
                                <option value="minimo">Igual al stock mínimo</option>
                                <option value="cerca">Cerca del stock mínimo (3)</option>
                            </select>
                        </div>

                    </div>
                    <div class="text-end">
                        <a href="/" class="btn btn-primary">Limpiar</a>
                        <button type="submit" class="btn btn-primary">Filtrar</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Tabla de productos --}}
        <div class="card">
            <div class="card-header">
                <h5>Listado de productos</h5>
            </div>
            <div class="card-body p-0">
                @if (isset($productos) && count($productos) > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0 table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Código</th>
                                    <th>Nombre</th>
                                    <th>Precio</th>
                                    <th>Stock</th>
                                    <th>Stock mínimo</th>
                                    <th>Tipo de oferta</th>
                                    <th>Oferta</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productos as $p)
                                    <tr>
                                        <td>{{ $p->codigo }}</td>
                                        <td>{{ $p->nombre }}</td>
                                        <td>${{ $p->precio }}</td>
                                        <td>{{ $p->stock }}</td>
                                        <td>{{ $p->stock_min }}</td>
                                        <td>
                                            @empty($p->tipo_oferta)
                                                <span class="badge bg-secondary">Sin oferta</span>
                                            @else
                                                <span class="badge bg-success">{{ $p->tipo_oferta }}</span>
                                            @endempty
                                        </td>
                                        <td>
                                            @empty($p->oferta)
                                                <span class="badge bg-secondary">Sin oferta</span>
                                            @else
                                                <span class="badge bg-success">%{{ $p->oferta }}</span>
                                            @endempty
                                        </td>
                                        <td class="d-flex gap-2">
                                            <a href="{{ url('Mod/' . $p->id) }}"
                                                class="btn btn-sm btn-outline-primary">Modificar</a>
                                            <form action="{{ url('Del/' . $p->id) }}" method="POST"
                                                onsubmit="return confirm('¿Seguro que deseas eliminarlo?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">Borrar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-4">
                        <p class="text-center text-muted">Aún no hay productos disponibles.</p>
                    </div>
                @endif
            </div>
        </div>

    </div>
@endsection