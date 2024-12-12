<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mi Aplicación')</title>
    
    <!-- Estilos de AdminLTE -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/styles.css') }}">
    <!-- Font Awesome (para iconos) -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Otros estilos que necesites -->
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Incluye tu navbar -->
        @include('partials.navbar')

        <!-- Incluye tu sidebar -->
        @include('partials.sidebar')

        <!-- Contenido principal -->
        <div class="content-wrapper">
            @yield('content')
        </div>

        <!-- Incluye tu footer -->
        @include('partials.footer')
    </div>

    <!-- Scripts de AdminLTE -->
    <script src="{{ asset('vendor/adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    <!-- Otros scripts que necesites -->
</body>
</html>