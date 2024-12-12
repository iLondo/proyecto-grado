<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registrar nuevo servicio</title>

    @push('css')
        <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/styles.css') }}">
    @endpush
</head>

<body>
    <!-- Modal para Registrar Nuevo Servicio -->
    <div class="modal" id="modalRegistrarServicio" tabindex="-1" role="dialog"
        aria-labelledby="modalRegistrarServicioLabel" aria-hidden="true" data-backdrop="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalRegistrarServicioLabel">REGISTRAR NUEVO SERVICIO</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('servicios_tiempo.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <!-- Campos del Formulario para Nuevo Servicio -->

                        <!-- Campo Nombre del Cliente -->
                        <div class="form-group">
                            <label for="nombre">Nombre del cliente</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input type="text" class="form-control" id="nombre" name="nombre"
                                    pattern="[A-Za-zñÑ\s]+" title="Solo se permiten letras y espacios." maxlength="50"
                                    required>
                            </div>
                        </div>
                        <!-- Campo Documento -->
                        <div class="form-group">
                            <label for="documento">Documento</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                </div>
                                <input type="text" class="form-control" id="documento" name="documento"
                                    pattern="\d+" title="Solo se permiten números." maxlength="10" required>
                            </div>
                        </div>
                        <!-- Campo Teléfono -->
                        <div class="form-group">
                            <label for="telefono">Teléfono</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                </div>
                                <input type="text" class="form-control" id="telefono" name="telefono"
                                    pattern="\d{10}" title="Solo se permiten números de 10 dígitos." maxlength="10"
                                    required>
                            </div>
                        </div>
                        <!-- Campo Placa del Vehículo -->
                        <div class="form-group">
                            <label for="placa">Placa del vehículo</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-car"></i></span>
                                </div>
                                <input type="text" class="form-control text-transform: uppercase;" id="placa"
                                    name="placa" style="text-transform: uppercase;"
                                    title="Solo se permiten letras y números (10 caracteres)." maxlength="10" required>
                            </div>
                        </div>

                        <!-- Campo Tipo de Vehículo -->
                        <div class="form-group">
                            <label for="tipo">Tipo de vehículo</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-cogs"></i></span>
                                </div>
                                <select class="form-control" id="tipo" name="tipo" required>
                                    <option value="" selected disabled>Seleccionar</option>
                                    <option value="Moto">Moto</option>
                                    <option value="Carro">Carro</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Registrar servicio</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</body>

</html>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<!-- SweetAlert JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.16/dist/sweetalert2.min.js"></script>

<!-- Aquí el código para SweetAlert -->
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

<script>
    // Limpiar los campos del formulario cuando se cierre el modal
    $('#modalRegistrarServicio').on('hidden.bs.modal', function() {
        // Limpiar todos los campos de entrada del formulario
        $(this).find('form')[0].reset();
    });
</script>
