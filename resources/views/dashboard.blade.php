@extends('adminlte::page')

@push('css')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/styles.css') }}">
@endpush

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

@section('content')
    <style>
        .hero {
            background-color: #ffffff;
            color: rgb(0, 0, 0);
            text-align: center;
            padding: 40px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            /* Ancho completo */
            height: 100vh;
            /* Alto completo de la ventana */
            box-sizing: border-box;
            /* Asegura que los márgenes y rellenos no afecten el tamaño total */
            position: absolute;
            /* Permite que ocupe toda la pantalla incluso si es el contenedor principal */
            top: 0;
            left: 0;
        }

        .hero h1 {
            font-size: 48px;
            font-weight: bold;
            margin: 0;
        }

        .hero p {
            font-size: 20px;
            margin-top: 15px;
        }

        .sin {
            font-size: 10px;
            font-weight: bold;
            margin: 0;
            text-align: center; 
        }
    </style>
    <title>Sistema de Parqueadero BETA</title>
    <div class="hero">
        <h1>PARQUEADERO PUBLICO</h1>
        <h1><b>"LA 22"</b></h1>
        <img src="{{ asset('vendor/adminlte/dist/img/logo.png') }}" alt="Logo" width="200" height="auto">
        <h1 class="sin">SISTEMA DE GESTION INTERNA</h1>

    @stop
