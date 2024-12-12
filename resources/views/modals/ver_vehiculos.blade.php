<!-- Modal de ver vehículos de un cliente -->
<div class="modal fade" id="verVehiculosModal{{ $cliente->id }}" tabindex="-1" role="dialog" data-backdrop="true"
    aria-labelledby="verVehiculosModalLabel{{ $cliente->id }}" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="verVehiculosModalLabel{{ $cliente->id }}">VEHÍCULOS DE
                    {{ strtoupper($cliente->nombre) }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Placa</th>
                            <th>Tipo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cliente->vehiculos as $vehiculo)
                            <tr>
                                <td>{{ $vehiculo->placa }}</td>
                                <td>{{ $vehiculo->tipo }}</td>
                                <td>
                                    <!-- Botón Editar Vehículo -->
                                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editVehiculoModal{{ $vehiculo->id }}">Editar</button>
                                    
                                    <!-- Botón Eliminar Vehículo -->
                                    <form action="{{ route('vehiculos.destroy', $vehiculo->id) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('¿Estás seguro de eliminar este vehículo?')">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @include('modals.edit_vehiculos')
            </div>
            <div class="modal-footer">
                <!-- Botón para abrir el modal de Registrar Nuevo Vehículo -->
                <button class="btn btn-success" data-toggle="modal" data-target="#registrarVehiculoModal{{ $cliente->id }}">
                    Registrar nuevo vehículo
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>