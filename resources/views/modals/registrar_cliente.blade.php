<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registrar un nuevo cliente</title>

    <!-- Vinculación del CSS de SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.16/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- Vinculación de JS de SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.16/dist/sweetalert2.min.js"></script>
    
</head>

<body>
    <!-- Modal para registrar un nuevo cliente -->
    <div class="modal" id="registrarClienteModal" tabindex="-1" role="dialog" aria-labelledby="registrarClienteModalLabel" aria-hidden="true" data-backdrop="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registrarClienteModalLabel">REGISTRAR NUEVO CLIENTE</h5>
                    <!-- Botón para cerrar el modal -->
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Formulario para registrar cliente -->
                <form action="{{ route('clientes.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <!-- Datos del cliente -->
                        <div class="form-group">
                            <h4>Datos del cliente</h4>
                        </div>

                        <!-- Campo para el nombre -->
                        <div class="form-group">
                            <label for="nombre">Nombre:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input type="text" name="nombre" class="form-control" id="nombre"
                                    pattern="[A-Za-zñÑ\s]+" title="Solo se permiten letras y espacios." maxlength="50"
                                    required>
                            </div>
                        </div>

                        <!-- Campo para el documento -->
                        <div class="form-group">
                            <label for="documento">Documento:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                </div>
                                <input type="text" name="documento" class="form-control" id="documento"
                                    pattern="\d+" title="Solo se permiten números." maxlength="10" required>
                            </div>
                        </div>

                        <!-- Campo para el teléfono -->
                        <div class="form-group">
                            <label for="telefono">Teléfono:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                                </div>
                                <input type="text" name="telefono" class="form-control" id="telefono"
                                    pattern="\d{10}" title="Solo se permiten números de 10 dígitos." maxlength="10"
                                    required>
                            </div>
                        </div>

                        <!-- Datos del vehículo -->
                        <hr>
                        <div class="form-group">
                            <h4>Datos del vehículo</h4>
                        </div>

                        <!-- Campo para la placa -->
                        <div class="form-group">
                            <label for="placa">Placa:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-car"></i></span>
                                </div>
                                <input type="text" name="vehiculo[placa]" class="form-control text-uppercase"
                                    id="placa" title="Solo se permiten letras y números (10 caracteres)." maxlength="10" required>
                            </div>
                        </div>

                        <!-- Campo para el tipo de vehículo -->
                        <div class="form-group">
                            <label for="tipo_vehiculo">Tipo:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-cogs"></i></span>
                                </div>
                                <select name="vehiculo[tipo]" class="form-control" id="tipo_vehiculo" required>
                                    <option value="" disabled selected>Seleccionar</option>
                                    <option value="carro">Carro</option>
                                    <option value="moto">Moto</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Botones del modal -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Mensajes de éxito o error con SweetAlert2 -->
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