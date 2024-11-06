@php
    $fondo = Session::get('fondo');
@endphp
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BeWids-Portal</title>
    <link rel="icon" href="{{ asset('imagenes/imagenesBase/logo.ico') }}" type="image/x-icon">
    <script src="@yield('rutaJs')"></script>
    <script src="@yield('rutaJs2')"></script>
    @yield('pusher')
    @vite('public/css/tailwindBase.css')
</head>
<body class=" md:max-h-screen @if($fondo) fondoFoto @else fondoBewids @endif" @if($fondo) style="background-image: url('data:image/jpeg;base64,{{$fondo}}')" @endif>
    @yield('contenido')
</body>
</html>