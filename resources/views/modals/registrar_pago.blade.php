<div class="modal fade" id="pagoModal" tabindex="-1" role="dialog" aria-labelledby="pagoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pagoModalLabel">REGISTRAR PAGO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="pagoForm" method="POST" action="{{ route('mensualidades.registrarPago') }}">
                    @csrf
                    <input type="hidden" id="mensualidad_id" name="mensualidad_id">

                    <!-- Campo Valor del Pago -->
                    <div class="mb-3">
                        <label for="valor_pago" class="form-label">Valor del pago</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-dollar-sign"></i>
                                </span>
                            </div>
                            <input type="number" class="form-control" id="valor_pago" name="valor_pago" placeholder="Ingrese el monto" required>
                        </div>
                    </div>
                    <!-- Campo Fecha del Pago -->
                    <div class="mb-3">
                        <label for="fecha_pago" class="form-label">Fecha del pago</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-calendar-alt"></i>
                                </span>
                            </div>
                            <input type="date" class="form-control" id="fecha_pago" name="fecha_pago" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success mb-0">Registrar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Incluyendo los estilos de Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">