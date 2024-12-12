@extends('adminlte::page')

@section('title', 'Seleccionar Informe')

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/styles.css') }}">
    <style>
        /* Estilo que hace que todo el contenido ocupe la página */
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

        /* Card del encabezado */
        .card-header {
            background-color: #1daae2;
            color: #fff;
            font-size: 2rem;
            padding: 15px;
            border-radius: 10px 10px 0 0;
            text-align: center;
        }

        /* Card de contenido */
        .card-body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100%; /* Asegura que el contenido ocupe todo el espacio de la card */
        }

        /* Estilo de la sección informativa */
        .info-section {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            transition: box-shadow 0.3s ease, transform 0.3s ease;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        /* Efecto de relieve en las cards */
        .info-section:hover {
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            transform: translateY(-5px);
        }

        .info-icon {
            font-size: 3rem;
            color: #1daae2;
            margin-bottom: 15px;
        }

        .info-title {
            font-size: 1.6rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
        }

        .info-btn {
            background-color: #1daae2;
            color: #fff;
            padding: 12px 25px;
            font-size: 1.1rem;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 15px;
            display: inline-block;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .info-btn:hover {
            background-color: #1daae2;
            transform: translateY(-3px);
        }

        .info-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .info-item {
            flex: 1 1 calc(33.33% - 20px);
            min-width: 250px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        /* Efecto de hover en los elementos */
        .info-item:hover {
            transform: scale(1.05);
        }

        /* Ajuste de los elementos para pantallas más pequeñas */
        @media (max-width: 768px) {
            .info-item {
                flex: 1 1 100%;
                min-width: auto;
            }

            .info-title {
                font-size: 1.4rem;
            }

            .info-btn {
                padding: 10px 20px;
                font-size: 1rem;
            }

            .info-icon {
                font-size: 2.5rem;
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
                <h1><i class="fas fa-file-alt"></i> Selecciona el tipo de informe</h1>
            </div>

            <div class="card-body">
                <div class="info-container">
                    <!-- Informe de Servicios -->
                    <div class="info-item">
                        <div class="info-section">
                            <div class="info-icon">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <div class="info-title">Servicios</div>
                            <a href="{{ route('grafico.servicios') }}" class="info-btn">
                                <i class="fas fa-eye"></i> Ver
                            </a>
                        </div>
                    </div>

                    <!-- Informe de Clientes -->
                    <div class="info-item">
                        <div class="info-section">
                            <div class="info-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="info-title">Clientes</div>
                            <a href="{{ route('grafico.clientes') }}" class="info-btn">
                                <i class="fas fa-eye"></i> Ver
                            </a>
                        </div>
                    </div>

                    <!-- Informe de Mensualidades -->
                    <div class="info-item">
                        <div class="info-section">
                            <div class="info-icon">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div class="info-title">Mensualidades</div>
                            <a href="grafico_mensualidades" class="info-btn">
                                <i class="fas fa-eye"></i> Ver
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection