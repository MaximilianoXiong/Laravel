<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
        crossorigin="anonymous"></script>

    <title>Pagina para administrar productos</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="/">Gestión de Productos</a>
            <div class="d-flex">
                <a href="/Agregar" class="btn btn-primary me-2">Agregar Producto</a>
                <a href="/Listar" class="btn btn-primary me-2">Listar Productos</a>
                <a href="/Actualizar" class="btn btn-primary me-2">Actualizar inventario</a>
                <a href="/Comprar" class="btn btn-primary me-2">Comprar</a>
                <a href="/VerCompras" class="btn btn-primary me-2">Ver compras</a>
            </div>
        </div>
    </nav>

    <main class="container">
        @yield('contenido')
    </main>
</body>

</html>