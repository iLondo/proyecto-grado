<!-- Modal de Confirmación de Eliminación de Cliente -->
<div class="modal fade" id="confirmarEliminarModal{{ $cliente->id }}" tabindex="-1"
    role="dialog" aria-labelledby="confirmarEliminarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <!-- Título del modal con fondo rojo para resaltar la importancia de la acción -->
                <h5 class="modal-title" id="confirmarEliminarModalLabel">Confirmar eliminación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <!-- Botón para cerrar el modal -->
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Mensaje de advertencia para la eliminación -->
                <p>¿Estás seguro de que deseas eliminar a <strong>{{ $cliente->nombre }}</strong>? Esta acción no se puede deshacer.</p>
            </div>
            <div class="modal-footer">
                <!-- Formulario de eliminación del cliente -->
                <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <!-- Botón de cancelación -->
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <!-- Botón de confirmación de eliminación con estilo de alerta -->
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Estilos específicos para el modal -->
@push('css')
    <style>
        /* Mejorando la apariencia del modal de confirmación */
        .modal-header.bg-danger {
            background-color: #dc3545; /* Rojo para resaltar la acción destructiva */
        }

        /* Estilo para el texto de la pregunta en el modal */
        .modal-body p {
            font-size: 1.1rem;
            color: #333;
        }

        /* Asegurando que el contenido del modal tenga buen espaciado */
        .modal-content {
            padding: 15px;
        }

        /* Botones del modal más estilizados */
        .btn-secondary, .btn-danger {
            font-size: 1rem;
            padding: 10px 20px;
        }

        .btn-danger {
            background-color: #e74c3c;
            border: none;
        }

        .btn-danger:hover {
            background-color: #c0392b;
        }
    </style>
@endpush