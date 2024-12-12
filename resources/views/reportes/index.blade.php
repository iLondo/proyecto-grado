@extends('adminlte::page')

@push('css')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/styles.css') }}">
    <style>
        /* Asegurando que el contenedor ocupe toda la pantalla */
        .container {
            height: 100vh; /* Altura total de la ventana */
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            padding-top: 10px;
        }

        /* Estilos para la card */
        .card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease, transform 0.3s ease;
            height: 100%; /* La card ocupará todo el espacio disponible */
        }

        .card:hover {
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            transform: translateY(-5px);
        }

        .card-header {
            background-color: #1daae2; /* Color de fondo de la card */
            color: #ffffff !important; /* Color de texto */
            font-size: 2rem;
            padding: 15px;
            border-radius: 10px 10px 0 0;
            text-align: center;
        }

        .card-body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            height: 100%; /* Asegura que el contenido ocupe todo el espacio de la card */
        }

        .card-icon {
            font-size: 90px;
            text-align: center;
            padding: 20px;
            color: #0077b3;
        }

        .card-title {
            font-size: 1.6rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
        }

        .report-icons {
            font-size: 30px;
            margin-top: 10px;
        }

        .report-icons i {
            margin: 0 10px;
            cursor: pointer;
        }

        .btn-success {
            background-color: #0077b3;
            color: white;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 1rem;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .btn-success:hover {
            background-color: #005f87;
            transform: translateY(-2px);
        }

        /* Diseño responsivo */
        @media (max-width: 768px) {
            .card-title {
                font-size: 1.4rem;
            }

            .card-icon {
                font-size: 70px;
            }

            .report-icons {
                font-size: 25px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <!-- Card que ocupa todo el contenido -->
        <div class="card">
            <!-- Título de la Card -->
            <div class="card-header">
                <h1><i class="fas fa-file"></i> REPORTES</h1>
            </div>

            <div class="card-body">
                <div class="row">
                    <!-- Card de Reporte de Clientes -->
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-icon text-primary">
                                <i class="fas fa-users"></i> <!-- Ícono de clientes -->
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">CLIENTES</h5>
                                <p>Generar</p>
                                <div class="report-icons">
                                    <i class="fas fa-file-excel text-success"></i>
                                    <a href="{{ url('export-clientes-vehiculos') }}" class="btn btn-success">
                                        Descargar Excel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card de Reporte de Tiempos -->
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-icon text-success">
                                <i class="fas fa-clock"></i> <!-- Ícono de tiempos -->
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">SERVICIOS DE TIEMPO</h5>
                                <p>Generar</p>
                                <div class="report-icons">
                                    <i class="fas fa-file-excel text-success"></i>
                                    <a href="{{ url('export-servicios-tiempo') }}" class="btn btn-success">
                                        Descargar Excel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card de Reporte de Mensualidades -->
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-icon text-warning">
                                <i class="fas fa-credit-card"></i> <!-- Ícono de mensualidades -->
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">MENSUALIDADES</h5>
                                <p>Generar</p>
                                <div class="report-icons">
                                    <i class="fas fa-file-excel text-success"></i>
                                    <a href="{{ url('export-mensualidades') }}" class="btn btn-success">
                                        Descargar Excel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection