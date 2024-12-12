@extends('adminlte::page')

@push('css')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/styles.css') }}">
    <style>
        /* Estilo de la lista de resultados del cliente */
        #clienteResults {
            max-height: 200px;
            overflow-y: auto;
            border: 1px solid #ccc;
            background-color: white;
            margin-top: 5px;
            padding: 5px 0;
            display: none;
            /* Oculta la lista de resultados inicialmente */
        }

        /* Estilo de cada resultado de cliente */
        .client-result {
            padding: 8px 15px;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        /* Efecto de hover sobre cada cliente en la lista */
        .client-result:hover {
            background-color: #f1f1f1;
        }

        /* Estilo para la tabla de mensualidades */
        .table-container {
            margin-top: 20px;
        }

        /* Estilo para las cabeceras de la tabla */
        th {
            background-color: #0077b3;
            color: white;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        @if ($mensualidades->isEmpty())
            <!-- Si no hay mensualidades activas, se muestra el botón para registrar una nueva -->
            <button type="button" class="btn btn-success mb-0" data-toggle="modal" data-target="#createMensualidadModal">
                Registrar nueva mensualidad
            </button>
            <h3 class="text-center">NO HAY MENSUALIDADES ACTIVAS EN ESTE MOMENTO</h3>
        @else
            <!-- Si existen mensualidades activas, se muestra la tabla -->
            <div class="table-container">
                <h1>Mensualidades activas</h1>
                <button type="button" class="btn btn-success mb-0" data-toggle="modal"
                    data-target="#createMensualidadModal">
                    Nueva mensualidad
                </button>

                <!-- Tabla con la información de las mensualidades -->
                <table class="table table-hover table-bordered table-sm w-100">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Vehículo</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Fin</th>
                            <th>Monto</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mensualidades as $mensualidad)
                            <tr>
                                <td>{{ $mensualidad->cliente->nombre }}</td>
                                <td>{{ $mensualidad->vehiculo->placa }} ({{ $mensualidad->vehiculo->tipo }})</td>
                                <td>{{ $mensualidad->fecha_inicio }}</td>
                                <td>{{ $mensualidad->fecha_fin }}</td>
                                <td><b>$</b>{{ number_format($mensualidad->monto, 0, '', '.') }}</td>
                                <td>
                                    <!-- Botón para registrar pago -->
                                    <button type="button" class="btn btn-success mb-0 btn-sm" data-toggle="modal"
                                        data-target="#pagoModal" data-id="{{ $mensualidad->id }}"
                                        data-monto="{{ $mensualidad->monto }}">
                                        Registrar pago
                                    </button>

                                    <!-- Botón para cancelar mensualidad -->
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                        data-target="#cancelarMensualidadModal{{ $mensualidad->id }}">
                                        Cancelar
                                    </button>
                                </td>
                            </tr>

                            <!-- Modal de Confirmación de Cancelación -->
                            <div class="modal fade" id="cancelarMensualidadModal{{ $mensualidad->id }}" tabindex="-1"
                                role="dialog" aria-labelledby="cancelarMensualidadModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="cancelarMensualidadModalLabel">Confirmar Cancelación
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            ¿Estás seguro de que deseas cancelar la mensualidad del cliente
                                            <strong>{{ $mensualidad->cliente->nombre }}</strong>?
                                            <p>Esta acción no se puede deshacer.</p>
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{ route('mensualidades.cancelar', $mensualidad->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-danger">Confirmar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
                <!-- Mostrar los enlaces de paginación -->
                <div class="d-flex justify-content-center mt-2">
                    {{ $mensualidades->links() }}
                </div>
            </div>
        @endif
    </div>
    @include('modals.registrar_mensualidad')
    @include('modals.registrar_pago')
@endsection

@section('js')
    <!-- Scripts necesarios para el funcionamiento de los modales y la búsqueda -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Función de búsqueda de clientes
        function searchClient() {
            const searchText = document.getElementById("clienteSearch").value;
            const resultDiv = document.getElementById("clienteResults");

            // Ocultar la lista si no hay texto de búsqueda
            if (!searchText) {
                resultDiv.innerHTML = '';
                resultDiv.style.display = 'none';
                resetClienteFields(); // Resetea los campos del cliente si se borra el texto
                return;
            }

            // Llamar al API para obtener los resultados de clientes
            fetch(`/search-clients?query=${searchText}`)
                .then(response => response.json())
                .then(data => {
                    // Si hay resultados, mostrar la lista
                    if (data.length > 0) {
                        resultDiv.style.display = 'block';
                        resultDiv.innerHTML = ''; // Limpiar resultados previos

                        data.forEach(client => {
                            const clientElement = document.createElement("div");
                            clientElement.classList.add("client-result");
                            clientElement.textContent = `${client.nombre} - ${client.documento}`;
                            clientElement.onclick = () => selectClient(
                                client); // Llamar a selectClient al hacer clic
                            resultDiv.appendChild(clientElement);
                        });
                    } else {
                        resultDiv.style.display = 'none'; // Ocultar si no hay resultados
                    }
                });
        }

        // Función para seleccionar un cliente de los resultados de búsqueda
        function selectClient(client) {
            document.getElementById("cliente_id").value = client.id;
            document.getElementById("clienteSearch").value = client.nombre;
            document.getElementById("clienteData").style.display = "block";
            document.getElementById("clienteDocumento").value = client.documento;
            document.getElementById("clienteTelefono").value = client.telefono;

            // Ocultar los resultados al seleccionar un cliente
            document.getElementById("clienteResults").style.display = 'none';

            // Obtener los vehículos del cliente seleccionado
            fetch(`/get-vehicles/${client.id}`)
                .then(response => response.json())
                .then(data => {
                    const vehiculoSelect = document.getElementById("vehiculo_id");
                    vehiculoSelect.innerHTML = '<option value="">Seleccione un vehículo</option>';
                    data.forEach(vehiculo => {
                        const option = document.createElement("option");
                        option.value = vehiculo.id;
                        option.textContent = `${vehiculo.placa} (${vehiculo.tipo})`;
                        vehiculoSelect.appendChild(option);
                    });
                });
        }

        // Cargar información de pago en el modal de pago
        $('#pagoModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var mensualidadId = button.data('id');
            var monto = button.data('monto');
            var modal = $(this);

            // Formatear el monto con separadores de miles
            var montoFormateado = new Intl.NumberFormat('es-CO').format(monto);

            // Asignar los valores al modal
            modal.find('#mensualidad_id').val(mensualidadId);
            modal.find('#valor_pago').val(`$ ${montoFormateado}`);
        });
    </script>

    <script>
        // Limpiar los campos del formulario cuando se cierre el modal
        $('#createMensualidadModal').on('hidden.bs.modal', function() {
            // Limpiar todos los campos de entrada del formulario
            $(this).find('form')[0].reset();

            $('#clienteResults').empty().hide();
        });
    </script>
@endsection
