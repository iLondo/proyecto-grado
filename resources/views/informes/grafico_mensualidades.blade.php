@extends('adminlte::page')

@section('title', 'Informe de Mensualidades')

@section('content')
    <div class="container-fluid">
        {{-- Botón de navegación --}}
        <a href="{{ url('/informes') }}" class="btn btn-secondary mb-4">
            <i class="fas fa-arrow-left"></i> Volver a la selección de informes
        </a>

        {{-- Título del informe --}}
        <h1 class="my-4">INFORME DE MENSUALIDADES</h1>

        {{-- Formulario de filtros por fecha --}}
        <form method="GET" action="{{ url()->current() }}" class="mb-4">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="fecha_inicio">Fecha Inicio:</label>
                    <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control"
                        value="{{ $fechaInicio }}">
                </div>
                <div class="form-group col-md-6">
                    <label for="fecha_fin">Fecha Fin:</label>
                    <input type="date" id="fecha_fin" name="fecha_fin" class="form-control" value="{{ $fechaFin }}">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Filtrar</button>
        </form>

        {{-- Resumen de estadísticas --}}
        <div class="row">
            {{-- Ingresos por motos --}}
            <div class="col-lg-4 col-12 mb-4">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>${{ number_format($ingresosMotos, 2) }}</h3>
                        <p>Ingresos por Motos</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-motorcycle"></i>
                    </div>
                </div>
            </div>

            {{-- Ingresos por carros --}}
            <div class="col-lg-4 col-12 mb-4">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>${{ number_format($ingresosCarros, 2) }}</h3>
                        <p>Ingresos por Carros</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-car"></i>
                    </div>
                </div>
            </div>

            {{-- Total mensualidades --}}
            <div class="col-lg-4 col-12 mb-4">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $mensualidades->count() }}</h3>
                        <p>Total Mensualidades Pagadas</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sección de gráficos --}}
        <div class="row">
            {{-- Gráfico de ingresos por tipo de vehículo (torta) --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Ingresos por Tipo de Vehículo</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="ingresosPorTipoChart"></canvas>
                    </div>
                </div>
            </div>

            {{-- Gráfico de pagos por mes --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Pagos por Mes</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="pagosPorMesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('js')
    {{-- Librería Chart.js --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
    <script>
        // Gráfico de ingresos por tipo de vehículo (torta)
        const ingresosPorTipoCtx = document.getElementById('ingresosPorTipoChart').getContext('2d');
        new Chart(ingresosPorTipoCtx, {
            type: 'pie',
            data: {
                labels: ['Motos', 'Carros'], // Etiquetas
                datasets: [{
                    data: [{{ $ingresosMotos }}, {{ $ingresosCarros }}], // Datos de los ingresos
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.6)', // Color para motos
                        'rgba(75, 192, 192, 0.6)'  // Color para carros
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                }
            }
        });

        // Gráfico de pagos por mes
        const pagosPorMesCtx = document.getElementById('pagosPorMesChart').getContext('2d');
        new Chart(pagosPorMesCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode(
                    $pagosPorMes->pluck('mes')->map(fn($mes) => \Carbon\Carbon::createFromFormat('!m', $mes)->format('F')),
                ) !!},
                datasets: [{
                    label: 'Total Pagos ($)',
                    data: {!! json_encode($pagosPorMes->pluck('total_pagos')) !!},
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endpush