<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>pagina todo</title>
</head>

<body>
    {{-- esto es una plantilla que todos usaran, cuando en una pagina "extienda" esto, debo poner el
    @extends('layouts.app') //que se refiere, "extiende el archivo en la carpeta layouts/app.blazor.php"
    luego usar las etiquetas @section('contenido') algo para mostrar @endsection //esto va a parar en
    @yield('contenido')
    --}}
    <a href="">op1</a> |
    <a href="">op2</a> |
    <a href="">op3</a>
    <br>

    @if (1 == 2)
        a huebo 1 es igual a 1 XD
    @else
        nope jajaj como van a ser iguales
    @endif

    @yield('contenido')
    <!-- aqui es lo que se ve, algo similar a un include-->
</body>

</html>