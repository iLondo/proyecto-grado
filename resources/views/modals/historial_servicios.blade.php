<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Historial de servicios</title>
    <!-- Vinculación de la hoja de estilos de Bootstrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/css/bootstrap.min.css">

    <style>
        /* Estilos personalizados para la modal */
        .modal-content {
            border-radius: 10px; /* Bordes redondeados para el contenido de la modal */
            border: 1px solid #ddd; /* Bordes suaves para la modal */
        }

        .modal-title {
            font-size: 1.5rem; /* Tamaño de fuente aumentado para el título */
            font-weight: bold; /* Título con texto en negrita */
        }

        /* Estilo para la tabla con encabezado fijo */
        .table-responsive {
            position: relative;
            max-height: 600px; /* Altura máxima para la tabla */
            overflow-y: auto; /* Habilita desplazamiento vertical */
            scroll-snap-type: y mandatory; /* Desplazamiento suave en la tabla */
        }

        table thead th {
            position: sticky; /* Fija el encabezado mientras se desplaza */
            top: 0;
            z-index: 10; /* Eleva el encabezado sobre las filas */
            background-color: #f8f9fa; /* Fondo sólido para evitar transparencias */
            border-bottom: 2px solid #dee2e6; /* Borde suave en la parte inferior */
            box-shadow: 0 2px 2px rgba(0, 0, 0, 0.1); /* Sombra para resaltar el encabezado */
            height: 50px; /* Altura fija del encabezado */
        }

        /* Alineación de filas en la tabla */
        tbody tr {
            scroll-snap-align: start; /* Ajusta cada fila como un punto de anclaje */
        }

        /* Alineación del texto en la tabla */
        .table th,
        .table td {
            text-align: center;
            vertical-align: middle; /* Centrado vertical de las celdas */
        }

        /* Estilos para los botones de la modal */
        .modal-footer .btn {
            border-radius: 0.375rem; /* Bordes redondeados para los botones */
            padding: 10px 20px; /* Más espacio de relleno para los botones */
        }

        /* Mejoras en la tabla en dispositivos pequeños */
        @media (max-width: 768px) {
            .table-responsive {
                max-height: 400px; /* Reduce la altura máxima de la tabla en pantallas pequeñas */
            }

            .table th, .table td {
                font-size: 0.9rem; /* Disminuye el tamaño de la fuente para pantallas más pequeñas */
            }
        }
    </style>
</head>

<body>
    <!-- Modal para mostrar el historial -->
    <div class="modal fade" id="modalHistorial" tabindex="-1" role="dialog" aria-labelledby="modalHistorialLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalHistorialLabel">Historial de servicios</h5>
                    <!-- Botón para cerrar la modal -->
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Contenedor de la tabla con desplazamiento vertical -->
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Documento</th>
                                    <th>Teléfono</th>
                                    <th>Placa</th>
                                    <th>Tipo</th>
                                    <th>Fecha y Hora Ingreso</th>
                                    <th>Fecha y Hora Salida</th>
                                    <th>Duración</th>
                                    <th>Total Pagado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Iteración sobre los servicios para llenar la tabla -->
                                @foreach ($servicios as $servicio)
                                    <tr>
                                        <td>{{ $servicio->nombre }}</td>
                                        <td>{{ $servicio->documento }}</td>
                                        <td>{{ $servicio->telefono }}</td>
                                        <td>{{ $servicio->placa }}</td>
                                        <td>{{ $servicio->tipo }}</td>
                                        <td>{{ $servicio->fecha_hora_ingreso }}</td>
                                        <td>{{ $servicio->fecha_hora_salida }}</td>
                                        <td>{{ $servicio->tiempo_estadia }}</td>
                                        <td>{{ $servicio->total_a_pagar }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- Botón de cierre -->
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts necesarios para Bootstrap -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.min.js"></script>
</body>
</html>