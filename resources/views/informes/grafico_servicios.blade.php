@extends('adminlte::page')

@section('title', 'Dashboard')

{{-- Estilos adicionales --}}
@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/styles.css') }}">
    <style>
        /* Permite el scroll vertical en el contenedor principal */
        .container-fluid {
            max-height: 90vh;
            /* Ajusta la altura máxima para que no sobrepase la pantalla */
            overflow-y: auto;
            /* Habilita scroll vertical */
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        {{-- Botón de navegación --}}
        <a href="{{ url('/informes') }}" class="btn btn-secondary mb-4">
            <i class="fas fa-arrow-left"></i> Volver a la selección de informes
        </a>

        {{-- Título del informe --}}
        <h1 class="my-4">INFORME DE SERVICIOS</h1>

        {{-- Formulario de filtros por fecha y estado --}}
        <form method="GET" action="{{ url()->current() }}" class="mb-4">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="fecha_inicio">Fecha Inicio:</label>
                    <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control"
                        value="{{ request('fecha_inicio') }}">
                </div>
                <div class="form-group col-md-4">
                    <label for="fecha_fin">Fecha Fin:</label>
                    <input type="date" id="fecha_fin" name="fecha_fin" class="form-control"
                        value="{{ request('fecha_fin') }}">
                </div>
                <div class="form-group col-md-4">
                    <label for="estado">Estado:</label>
                    <select id="estado" name="estado" class="form-control">
                        <option value="" {{ request('estado') == '' ? 'selected' : '' }}>Todos</option>
                        <option value="en_curso" {{ request('estado') == 'en_curso' ? 'selected' : '' }}>En curso</option>
                        <option value="terminado" {{ request('estado') == 'terminado' ? 'selected' : '' }}>Terminado
                        </option>
                        <option value="cancelado" {{ request('estado') == 'cancelado' ? 'selected' : '' }}>Cancelado
                        </option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Filtrar</button>
        </form>

        {{-- Resumen de estadísticas --}}
        <div class="row">
            {{-- Total ingresos --}}
            <div class="col-lg-3 col-6 mb-4">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>${{ number_format($totalIngresos, 2) }}</h3>
                        <p>Total ingresos</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                </div>
            </div>

            {{-- Total de servicios (según estado) --}}
            <div class="col-lg-3 col-6 mb-4">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $cantidadServicios }}</h3>
                        <p>Total de servicios ({{ request('estado') ? ucfirst(request('estado')) : 'Todos' }})</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-car"></i>
                    </div>
                </div>
            </div>

            {{-- Tiempo promedio de estadía --}}
            <div class="col-lg-3 col-6 mb-4">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ number_format($promedioTiempoEstadia, 2) }} hrs</h3>
                        <p>Tiempo promedio de estadía</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sección de gráficos --}}
        <div class="row">
            {{-- Gráfico de ingresos por día --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Ingresos por día</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="ingresosPorDiaChart"></canvas>
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
        // Configuración del gráfico de ingresos por día
        const ingresosPorDiaCtx = document.getElementById('ingresosPorDiaChart').getContext('2d');
        new Chart(ingresosPorDiaCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($ingresosPorDia->pluck('fecha')) !!},
                datasets: [{
                    label: 'Ingresos por Día',
                    data: {!! json_encode($ingresosPorDia->pluck('total')) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            }
        });
    </script>
@endpush
