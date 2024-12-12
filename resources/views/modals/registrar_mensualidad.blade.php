<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.16/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.16/dist/sweetalert2.min.js"></script>
</head>
<body>
    <div class="modal fade" id="createMensualidadModal" tabindex="-1" role="dialog" aria-labelledby="createMensualidadModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createMensualidadModalLabel">REGISTRAR NUEVA MENSUALIDAD</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Formulario para registrar mensualidad -->
                    <form id="mensualidadForm" method="POST" action="{{ route('mensualidades.store') }}">
                        @csrf
                        <!-- Cliente -->
                        <div class="mb-3">
                            <label for="cliente" class="form-label">Cliente</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" id="clienteSearch" name="cliente" placeholder="Buscar cliente por nombre o cédula" oninput="searchClient()">
                            </div>
                            <div id="clienteResults"></div> <!-- Aquí se mostrarán los resultados de la búsqueda -->
                            <input type="hidden" id="cliente_id" name="cliente_id">
                        </div>
                        <!-- Datos del Cliente -->
                        <div id="clienteData" class="mb-3" style="display: none;">
                            <label for="clienteDocumento" class="form-label">Documento</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-id-card"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" id="clienteDocumento" name="documento" readonly>
                            </div>
                            <label for="clienteTelefono" class="form-label mt-2">Teléfono</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-phone"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" id="clienteTelefono" name="telefono" readonly>
                            </div>
                        </div>
                        <!-- Vehículo -->
                        <div class="mb-3">
                            <label for="vehiculo" class="form-label">Vehículo</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-car"></i>
                                    </span>
                                </div>
                                <select id="vehiculo_id" name="vehiculo_id" class="form-control">
                                    <option value="">Seleccione un vehículo</option>
                                </select>
                            </div>
                        </div>
                        <!-- Fechas -->
                        <div class="mb-3">
                            <label for="fecha_inicio" class="form-label">Fecha de inicio</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-calendar-alt"></i>
                                    </span>
                                </div>
                                <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="fecha_fin" class="form-label">Fecha de fin</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-calendar-alt"></i>
                                    </span>
                                </div>
                                <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required>
                            </div>
                        </div>
                        <!-- Monto -->
                        <div class="mb-3">
                            <label for="monto" class="form-label">Monto a pagar</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-dollar-sign"></i>
                                    </span>
                                </div>
                                <input type="number" class="form-control" id="monto" name="monto" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success mb-0">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: "{{ session('success') }}",
                confirmButtonText: 'Aceptar'
            });
        </script>
    @elseif (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: "{{ session('error') }}",
                confirmButtonText: 'Aceptar'
            });
        </script>
    @endif
</body>
</html>