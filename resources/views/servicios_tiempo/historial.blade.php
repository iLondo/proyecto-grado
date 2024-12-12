@extends('adminlte::page')

@section('title', 'Historial de Servicios')

@push('css')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/styles.css') }}">
@endpush

@section('content_header')

@endsection

@section('content')
    <div class="container-fluid">
        <!-- Tabla de Historial de Servicios -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <div class="table_container">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <!-- Botón de volver alineado a la izquierda -->
                            <a href="{{ route('servicios_tiempo.index') }}" class="btn btn-info">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>

                            <!-- Título centrado -->
                            <h1 class="text-center flex-grow-1"><i class="fas fa-history"></i> Historial de servicios</h1>
                        </div>

                        <div class="mb-3 d-flex justify-content-start align-items-center">
                            <div>
                            </div>
                            <div class="mb-3 d-flex justify-content-start align-items-center">
                                <!-- Texto del filtro -->
                                <div class="mr-2">
                                    <p><strong>Filtrar por estado:</strong></p>
                                </div>
                                <!-- Selector de estado -->
                                <div>
                                    <form method="GET" action="{{ route('historial.servicios') }}" id="filtro-estado"
                                        class="mb-3">
                                        <select class="custom-select w-auto" name="estado"
                                            onchange="document.getElementById('filtro-estado').submit()">
                                            <option value="" {{ request('estado') == '' ? 'selected' : '' }}>Todos
                                            </option>
                                            <option value="terminado"
                                                {{ request('estado') == 'terminado' ? 'selected' : '' }}>Terminado</option>
                                            <option value="en_curso"
                                                {{ request('estado') == 'en_curso' ? 'selected' : '' }}>En curso</option>
                                            <option value="cancelado"
                                                {{ request('estado') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                                        </select>
                                    </form>
                                </div>
                            </div>

                        </div>

                        <!-- Card Header con color dinámico según estado -->
                        <div class="card-header 
                            @if(request('estado') == 'terminado') bg-success 
                            @elseif(request('estado') == 'en_curso') bg-warning 
                            @elseif(request('estado') == 'cancelado') bg-danger 
                            @else bg-primary @endif text-white">
                            @php
                                $titulo = match (request('estado')) {
                                    'terminado' => 'Servicios terminados',
                                    'en_curso' => 'Servicios en curso',
                                    'cancelado' => 'Servicios cancelados',
                                    default => 'Todos los servicios',
                                };
                            @endphp
                            <h3 class="card-title">{{ $titulo }}</h3>
                        </div>

                        <!-- Tabla de servicios -->
                        <table class="table table-hover table-bordered table-sm w-100">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Nombre</th>
                                    <th>Documento</th>
                                    <th>Teléfono</th>
                                    <th>Placa</th>
                                    <th>Tipo</th>
                                    <th>Fecha y Hora Ingreso</th>
                                    <th>Fecha y Hora Salida</th>
                                    <th>Duración</th>
                                    <th>Total Pagado</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($historialServicios as $servicio)
                                    <tr>
                                        <td>{{ $servicio->nombre }}</td>
                                        <td>{{ $servicio->documento }}</td>
                                        <td>{{ $servicio->telefono }}</td>
                                        <td>{{ $servicio->placa }}</td>
                                        <td>{{ $servicio->tipo }}</td>
                                        <td>{{ $servicio->fecha_hora_ingreso }}</td>
                                        <td>{{ $servicio->fecha_hora_salida }}</td>
                                        <td>{{ $servicio->tiempo_estadia }}</td>
                                        <td><b>$</b>{{ number_format($servicio->total_a_pagar, 0, '', '.') }}</td>
                                        <td>
                                            @switch($servicio->estado)
                                                @case('terminado')
                                                    <span class="badge badge-success">Terminado</span>
                                                @break

                                                @case('en_curso')
                                                    <span class="badge badge-warning">En curso</span>
                                                @break

                                                @case('cancelado')
                                                    <span class="badge badge-danger">Cancelado</span>
                                                @break

                                                @default
                                                    <span class="badge badge-secondary">Desconocido</span>
                                            @endswitch
                                        </td>
                                    </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center">No se encontraron servicios con este filtro.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center mt-2">
                            {{ $historialServicios->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.min.js"></script>
@endpush