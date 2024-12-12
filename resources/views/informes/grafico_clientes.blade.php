@extends('adminlte::page')

@section('title', 'Informe de Clientes')

{{-- Incluir estilos adicionales --}}
@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/styles.css') }}">

    <style>
        /* Ajustar el tamaño y la posición del gráfico */
        #clientesPorFechaChart {
            max-width: 800px; /* Establecer ancho máximo */
            max-height: 500px; /* Establecer altura máxima */
            margin: 0 auto; /* Centrar el gráfico */
        }
    </style>
@endpush

@section('content')
    {{-- Botón para volver a la selección de informes --}}
    <a href="{{ url('/informes') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Volver a la selección de informes
    </a>

    <div class="container-fluid">
        {{-- Título de la sección --}}
        <h1 class="my-4">INFORME DE CLIENTES</h1>

        {{-- Estadísticas rápidas --}}
        <div class="row">
            {{-- Cantidad total de clientes --}}
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $cantidadClientes }}</h3>
                        <p>Clientes</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>

            {{-- Cantidad total de vehículos --}}
            <div class="col-lg-3 col-6">
                <div class="small-box bg-secondary">
                    <div class="inner">
                        <h3>{{ $cantidadVehiculos }}</h3>
                        <p>Vehículos</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-car"></i>
                    </div>
                </div>
            </div>

            {{-- Cantidad de motocicletas --}}
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $cantidadVehiculosMoto }}</h3>
                        <p>Motos</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-motorcycle"></i>
                    </div>
                </div>
            </div>

            {{-- Cantidad de carros --}}
            <div class="col-lg-3 col-6">
                <div class="small-box bg-lightblue">
                    <div class="inner">
                        <h3>{{ $cantidadVehiculosCarro }}</h3>
                        <p>Carros</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-car-side"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Gráfico: Clientes registrados por fecha --}}
        <div class="card mt-4">
            <div class="card-header">
                <h3 class="card-title">Clientes registrados por fecha</h3>
            </div>
            <div class="card-body">
                <canvas id="clientesPorFechaChart"></canvas>
            </div>
        </div>
    </div>
@endsection

@push('js')
    {{-- Inclusión de librerías de Chart.js --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
    <script>
        // Calcular la línea de tendencia a partir de los datos
        function calcularLineaDeTendencia(datos) {
            let sumaX = 0, sumaY = 0, sumaXY = 0, sumaX2 = 0;
            const n = datos.length;

            datos.forEach((y, x) => {
                sumaX += x;
                sumaY += y;
                sumaXY += x * y;
                sumaX2 += x * x;
            });

            const pendiente = (n * sumaXY - sumaX * sumaY) / (n * sumaX2 - sumaX * sumaX);
            const intercepto = (sumaY - pendiente * sumaX) / n;

            return datos.map((_, x) => pendiente * x + intercepto);
        }

        // Datos obtenidos del backend
        const datosClientes = {!! json_encode($fechasRegistroClientes->pluck('total')) !!};
        const fechas = {!! json_encode($fechasRegistroClientes->pluck('fecha_registro')) !!};

        // Cálculo de la línea de tendencia
        const lineaDeTendencia = calcularLineaDeTendencia(datosClientes);

        // Configuración del gráfico
        const clientesPorFechaCtx = document.getElementById('clientesPorFechaChart').getContext('2d');
        new Chart(clientesPorFechaCtx, {
            type: 'bar', // Tipo de gráfico: barras
            data: {
                labels: fechas, // Etiquetas (fechas)
                datasets: [
                    {
                        label: 'Clientes registrados',
                        data: datosClientes, // Datos de clientes registrados
                        backgroundColor: 'rgba(54, 162, 235, 1)', // Color de las barras
                        borderColor: 'rgba(54, 162, 235, 1)', // Color del borde
                        borderWidth: 1
                    },
                    {
                        label: 'Línea de tendencia',
                        data: lineaDeTendencia, // Datos de la línea de tendencia
                        type: 'line', // Tipo de gráfico: línea
                        borderColor: 'rgba(255, 99, 132, 1)', // Color de la línea
                        borderWidth: 2,
                        fill: false // Sin relleno
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        ticks: {
                            autoSkip: false, // Mostrar todas las etiquetas
                            maxRotation: 90, // Rotación máxima
                            minRotation: 45 // Rotación mínima
                        }
                    },
                    y: {
                        beginAtZero: true // Iniciar desde 0
                    }
                }
            }
        });
    </script>
@endpush