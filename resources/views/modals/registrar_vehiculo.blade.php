<div class="modal fade" id="registrarVehiculoModal{{ $cliente->id }}" tabindex="-1"
    role="dialog" aria-labelledby="registrarVehiculoModalLabel{{ $cliente->id }}"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">REGISTRAR VEHÍCULO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('vehiculos.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="cliente_id" value="{{ $cliente->id }}">
                    
                    <!-- Campo Placa con ícono -->
                    <div class="form-group">
                        <label for="placa{{ $cliente->id }}">Placa</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-car"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" id="placa{{ $cliente->id }}"
                                name="placa" placeholder="Ingrese la placa" required>
                        </div>
                    </div>
                    
                    <!-- Campo Tipo con ícono -->
                    <div class="form-group">
                        <label for="tipo{{ $cliente->id }}">Tipo</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-car-side"></i>
                                </span>
                            </div>
                            <select class="form-control" id="tipo{{ $cliente->id }}" name="tipo" required>
                                <option value="" selected disabled>Seleccionar tipo</option>
                                <option value="Moto">Moto</option>
                                <option value="Carro">Carro</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Registrar</button>
                </div>
            </form>
        </div>
    </div>
</div>