<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('titulo')</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap"
            rel="stylesheet">
        <link rel="stylesheet" href="{{asset('css/estilosBase.css')}}">
        <link rel="stylesheet" href="@yield('rutaEstilos')">
        <link rel="stylesheet" href="@yield('rutaEstilos2')">
        <script src="@yield('rutaJs')"></script>
        <script src="@yield('rutaJs2')"></script>   
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
        <link rel="icon" href="{{ asset('imagenes/imagenesBase/logo.ico') }}" type="image/x-icon">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
        

    </head>
    <body>
        
        @yield('contenido')
    </body>
</html>