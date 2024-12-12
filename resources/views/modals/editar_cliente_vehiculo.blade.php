<div class="modal fade" id="editClienteModal{{ $cliente->id }}" tabindex="-1" role="dialog"
    aria-labelledby="editClienteModalLabel{{ $cliente->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" >EDITAR DATOS</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('clientes.update', $cliente->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Título para Datos del Cliente --}}
                    <h4 class="mt-0 mb-0">Datos del Cliente</h4>

                    {{-- Datos del cliente --}}
                    <div class="form-group">
                        <label for="nombre{{ $cliente->id }}">Nombre:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" class="form-control" id="nombre{{ $cliente->id }}" name="nombre"
                                value="{{ $cliente->nombre }}" pattern="[A-Za-zñÑ\s]+" title="Solo se permiten letras y espacios."
                                maxlength="50" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="documento{{ $cliente->id }}">Documento:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                            </div>
                            <input type="text" class="form-control" id="documento{{ $cliente->id }}" name="documento"
                                value="{{ $cliente->documento }}" pattern="\d+" title="Solo se permiten números."
                                maxlength="10" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="telefono{{ $cliente->id }}">Teléfono:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                            </div>
                            <input type="text" class="form-control" id="telefono{{ $cliente->id }}" name="telefono"
                                value="{{ $cliente->telefono }}" pattern="\d{10}" title="Solo se permiten números de 10 dígitos."
                                maxlength="10" required>
                        </div>
                    </div>

                    {{-- Título para Datos del Vehículo --}}
                    @if ($cliente->vehiculos->count() > 0)
                    <div class="form-group mt-4"><h4>Datos del Vehículo</h4>
                    </div>
                        
                        {{-- Selección de vehículo --}}
                        <div class="form-group">
                            <label for="vehiculo{{ $cliente->id }}">Seleccionar Vehículo:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-car"></i></span>
                                </div>
                                <select class="form-control vehiculo-select" id="vehiculo{{ $cliente->id }}"
                                    name="vehiculo_id" data-cliente-id="{{ $cliente->id }}">
                                    <option value="" selected disabled>Seleccione un vehículo</option>
                                    @foreach ($cliente->vehiculos as $vehiculo)
                                        <option value="{{ $vehiculo->id }}" data-placa="{{ $vehiculo->placa }}"
                                            data-tipo="{{ $vehiculo->tipo }}">
                                            {{ $vehiculo->placa }} - {{ $vehiculo->tipo }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Campos de datos del vehículo --}}
                        <div id="vehiculoDatos{{ $cliente->id }}">
                            <div class="form-group">
                                <label for="placa{{ $cliente->id }}">Placa:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-clipboard-list"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="placa{{ $cliente->id }}" name="placa"
                                        value="" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="tipo{{ $cliente->id }}">Tipo:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-cogs"></i></span>
                                    </div>
                                    <select class="form-control" id="tipo{{ $cliente->id }}" name="tipo" required>
                                        <option value="" selected disabled>Seleccionar tipo</option>
                                        <option value="Moto">Moto</option>
                                        <option value="Carro">Carro</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
