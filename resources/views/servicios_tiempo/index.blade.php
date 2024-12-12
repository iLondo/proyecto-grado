@extends('adminlte::page')

@push('css')
<link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/styles.css') }}">
@endpush

@section('content')
    <div class="container-fluid">
        <!-- Tabla de Servicios -->
        <div class="table-container">
            <h1><i class="fas fa-calendar-alt"></i> SERVICIOS</h1>
            <div class="mb-3">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalRegistrarServicio">
                    Nuevo servicio
                </button>
                <a href="{{ route('historial.servicios') }}" class="btn btn-info">Historial</a>
            </div>
            <table class="table table-hover table-bordered table-sm w-100">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Documento</th>
                        <th>Teléfono</th>
                        <th>Placa</th>
                        <th>Tipo</th>
                        <th>Fecha y Hora de Ingreso</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($servicios as $servicio)
                        <tr>
                            <td>{{ $servicio->nombre }}</td>
                            <td>{{ $servicio->documento }}</td>
                            <td>{{ $servicio->telefono }}</td>
                            <td>{{ $servicio->placa }}</td>
                            <td>{{ $servicio->tipo }}</td>
                            <td>{{ $servicio->fecha_hora_ingreso }}</td>
                            <td>
                                <!-- Botón para marcar salida -->
                                <form id="formMarcarSalida-{{ $servicio->id }}"
                                    action="{{ route('servicios_tiempo.marcar_salida', $servicio->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="nombre" value="{{ $servicio->nombre }}">
                                    <input type="hidden" name="documento" value="{{ $servicio->documento }}">
                                    <input type="hidden" name="telefono" value="{{ $servicio->telefono }}">
                                    <input type="hidden" name="placa" value="{{ $servicio->placa }}">
                                    <input type="hidden" name="tipo" value="{{ $servicio->tipo }}">
                                    <input type="hidden" name="fecha_ingreso" value="{{ $servicio->fecha_hora_ingreso }}">
                                    <input type="hidden" name="fecha_salida" value="{{ $servicio->fecha_hora_salida }}">
                                    <input type="hidden" name="tiempo_estadia" value="{{ $servicio->tiempo_estadia }}">
                                    <input type="hidden" name="total_a_pagar" value="{{ $servicio->total_a_pagar }}">
                                    <button type="button" class="btn btn-warning btn-sm"
                                        onclick="confirmarSalida({{ $servicio->id }})">
                                        Marcar Salida
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Paginación -->
        <div class="d-flex justify-content-center mt-4">
            {{ $servicios->links('vendor.pagination.default') }}
        </div>
    </div>

    <!-- Modal para Registrar Nuevo Servicio -->
    @include('modals.registrar_servicio')
    @include('modals.ver_resumen_servicio')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Script para manejar la confirmación de marcar salida -->
    <script>
        function confirmarSalida(servicioId) {
            Swal.fire({
                title: '¿Está seguro?',
                text: "Esta acción marcará la salida del vehículo.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, marcar salida',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#formMarcarSalida-' + servicioId).submit();
                }
            });
        }


        // Mostrar el modal de resumen después de enviar los datos
        $(document).ready(function() {
            @if (session('mostrar_resumen'))
                $('#modalResumenServicio').modal('show');
                $('#resumen-nombre').text("{{ session('mostrar_resumen.nombre') }}");
                $('#resumen-documento').text("{{ session('mostrar_resumen.documento') }}");
                $('#resumen-telefono').text("{{ session('mostrar_resumen.telefono') }}");
                $('#resumen-placa').text("{{ session('mostrar_resumen.placa') }}");
                $('#resumen-tipo').text("{{ session('mostrar_resumen.tipo') }}");
                $('#resumen-fecha-ingreso').text("{{ session('mostrar_resumen.fecha_ingreso') }}");
                $('#resumen-fecha-salida').text("{{ session('mostrar_resumen.fecha_salida') }}");
                $('#resumen-tiempo-estadia').text("{{ session('mostrar_resumen.tiempo_estadia') }}");
                $('#resumen-total-pagar').text("{{ session('mostrar_resumen.total_a_pagar') }}");
            @endif
        });
    </script>
@endsection
