@extends('adminlte::page')

@push('css')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/styles.css') }}">
@endpush

<style>
    /* Asegurar alineación en la tabla */
    .d-flex {
        display: flex;
        align-items: right;
    }

    /* Ajustar el espaciado en el dropdown */
    .dropdown-menu .d-flex {
        padding: 5px 80px;
    }

    .dropdown-menu .d-flex span {
        flex-grow: 1;
        margin-right: 3px;
    }

    .d-flex.align-items-center span {
        margin-right: 2px;
        margin-top: -13px;

    }

    .d-flex.align-items-center form {
        margin-left: 0;
        /* Elimina cualquier margen extra al formulario */
    }

    td.vehiculos-columna {
        text-align: center;
        /* Centrar horizontalmente */
        vertical-align: middle;
        /* Centrar verticalmente */
    }
</style>

@section('content')
    <div class="container-fluid">
        <div class="table-container">
            <h1><i class="fas fa-users"></i> CLIENTES</h1>
            <button class="btn btn-success mb-0" data-toggle="modal" data-target="#registrarClienteModal">
                Nuevo
            </button>
            <table class="table table-hover table-bordered table-sm w-100">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Documento</th>
                        <th>Teléfono</th>
                        <th>Vehículos</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clientes as $cliente)
                        <tr>
                            <td>{{ $cliente->nombre }}</td>
                            <td>{{ $cliente->documento }}</td>
                            <td>{{ $cliente->telefono }}</td>
                            <td class ="vehiculos-columna">
                                @if ($cliente->vehiculos->isEmpty())
                                    <span class="text-muted">No tiene vehículos</span>
                                @elseif ($cliente->vehiculos->count() === 1)
                                    <div class="d-flex align-items-center justify-content-center">
                                        <div class="d-flex align-items-center">
                                            <span>{{ $cliente->vehiculos->first()->placa }} -
                                                {{ $cliente->vehiculos->first()->tipo }}</span>
                                            <form
                                                action="{{ route('vehiculos.destroy', $cliente->vehiculos->first()->id) }}"
                                                method="POST" class="ml-1" id="formEliminarVehiculo{{ $cliente->vehiculos->first()->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmarEliminarVehiculo({{ $cliente->vehiculos->first()->id }})" title="Eliminar vehículo">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @else
                                    <div class="dropdown">
                                        <button class="btn btn-info btn-sm dropdown-toggle" type="button"
                                            id="vehiculosDropdown{{ $cliente->id }}" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            Ver Vehículos
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="vehiculosDropdown{{ $cliente->id }}">
                                            @foreach ($cliente->vehiculos as $vehiculo)
                                                <div class="d-flex justify-content-between align-items-center px-3 py-2">
                                                    <span>{{ $vehiculo->placa }} - {{ $vehiculo->tipo }}</span>
                                                    <form action="{{ route('vehiculos.destroy', $vehiculo->id) }}" method="POST" class="ml-2" id="formEliminarVehiculo{{ $vehiculo->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmarEliminarVehiculo({{ $vehiculo->id }})" title="Eliminar vehículo">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>                                                    
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                        id="accionesDropdown{{ $cliente->id }}" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        Acciones
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="accionesDropdown{{ $cliente->id }}">
                                        <!-- Botón de Editar Cliente -->
                                        <button class="dropdown-item" data-toggle="modal"
                                            data-target="#editClienteModal{{ $cliente->id }}">
                                            <i class="fas fa-edit"></i> Editar
                                        </button>
                                        <!-- Botón de Registrar Vehículo -->
                                        <button class="dropdown-item" data-toggle="modal"
                                            data-target="#registrarVehiculoModal{{ $cliente->id }}">
                                            <i class="fas fa-car"></i> Nuevo vehículo
                                        </button>
                                        <!-- Botón de Eliminar Cliente -->
                                        <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST"
                                            class="d-inline-block" id="formEliminarCliente{{ $cliente->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="dropdown-item"
                                                onclick="confirmarEliminar({{ $cliente->id }})">
                                                <i class="fas fa-trash"></i> Eliminar cliente
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        {{-- Modal para editar cliente y vehículo --}}
                        @include('modals.editar_cliente_vehiculo', ['cliente' => $cliente])
                        {{-- Modal para registrar vehículo --}}
                        @include('modals.registrar_vehiculo')
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center mt-2">
                {{ $clientes->links() }}
            </div>
        </div>
    </div>
    {{-- Modal para registrar cliente --}}
    @include('modals.registrar_cliente')
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmarEliminar(clienteId) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡Esta acción no se puede deshacer!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminarlo',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Si el usuario confirma, enviar el formulario de eliminación del cliente
                document.getElementById('formEliminarCliente' + clienteId).submit();
            }
        });
    }

    function confirmarEliminarVehiculo(vehiculoId) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡Esta acción no se puede deshacer!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminarlo',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Si el usuario confirma, enviar el formulario de eliminación del vehículo
                document.getElementById('formEliminarVehiculo' + vehiculoId).submit();
            }
        });
    }
</script>

<script>
    $(document).ready(function() {

        $('#registrarClienteModal').on('hidden.bs.modal', function() {
            $(this).find('form')[0].reset();
        });

        // Limpiar los campos de vehículo cuando se abre un modal específico de un cliente
        $('.modal').on('show.bs.modal', function() {
            const modalId = $(this).attr('id');
            // Verificar que el modal es el correcto
            if (modalId.includes('editClienteModal')) {
                const clienteId = $(this).attr('id').split('editClienteModal')[
                    1]; // Extraer ID del cliente
                // Restablecer el select de vehículos al valor predeterminado
                $(`#vehiculo${clienteId}`).val(
                    ''); // O el valor que corresponda a "Seleccionar vehículo"
                // Limpiar los campos relacionados con el vehículo
                $(`#placa${clienteId}`).val('');
                $(`#tipo${clienteId}`).val(''); // Restablecer el select a "Seleccionar tipo"
            }
        });
        // Detectar el cambio en el select de vehículos
        $('.vehiculo-select').on('change', function() {
            const clienteId = $(this).data('cliente-id');
            const selectedOption = $(this).find('option:selected');
            if (selectedOption.val() === '') {
                // Si se selecciona "Seleccione un vehículo", vaciar los campos
                $(`#placa${clienteId}`).val('');
                $(`#tipo${clienteId}`).val(''); // Restablecer a "Seleccionar tipo"
            } else {
                const placa = selectedOption.data('placa');
                const tipo = selectedOption.data('tipo');
                // Actualizar los campos de placa y tipo con los valores del vehículo seleccionado
                $(`#placa${clienteId}`).val(placa);
                $(`#tipo${clienteId}`).val(tipo);
            }
        });
    });
</script>