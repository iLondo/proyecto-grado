<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="vendor/adminlte/dist/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/2.3.7/purify.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <title>Resumen de Factura</title>
    <style>
        .modal-content {
            border-radius: 10px;
            border: 1px solid #ddd;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .modal-header {
            background-color: #f8f9fa;
            border-bottom: 2px solid #ddd;
            padding: 1rem;
        }
        .modal-title {
            font-size: 1.5rem;
            color: #343a40;
        }
        .modal-body {
            font-family: 'Arial', sans-serif;
            padding: 2rem;
            line-height: 1.6;
        }
        .section {
            margin-bottom: 1.5rem;
            padding: 1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .section-title {
            font-size: 1.2rem;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 1rem;
            text-decoration: underline;
        }
        .modal-footer {
            padding: 1rem;
            background-color: #f8f9fa;
        }
        .modal-footer button {
            font-size: 1rem;
            border-radius: 5px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
        }
        .info-row p {
            margin: 0.5rem 0;
            font-size: 1rem;
            width: 48%;
        }
    </style>
</head>
<body>
    <div class="modal fade" id="modalResumenServicio" tabindex="-1" role="dialog" aria-labelledby="modalResumenServicioLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalResumenServicioLabel">Resumen del servicio</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="contenidoFactura">
                    <!-- Datos del Cliente -->
                    <div class="section">
                        <div class="section-title">Datos del cliente</div>
                        <p><strong>Nombre:</strong> <span id="resumen-nombre"></span></p>
                        <p><strong>Documento:</strong> <span id="resumen-documento"></span></p>
                        <p><strong>Teléfono:</strong> <span id="resumen-telefono"></span></p>
                    </div>

                    <!-- Datos del Vehículo -->
                    <div class="section">
                        <div class="section-title">Datos del vehículo</div>
                        <p><strong>Placa:</strong> <span id="resumen-placa"></span></p>
                        <p><strong>Tipo:</strong> <span id="resumen-tipo"></span></p>
                    </div>

                    <!-- Datos de Cobro -->
                    <div class="section">
                        <div class="section-title">Datos de cobro</div>
                        <p><strong>Fecha de Ingreso:</strong> <span id="resumen-fecha-ingreso"></span></p>
                        <p><strong>Fecha de Salida:</strong> <span id="resumen-fecha-salida"></span></p>
                        <p><strong>Tiempo de Estadía:</strong> <span id="resumen-tiempo-estadia"></span></p>
                        <p><strong>Total a Pagar:</strong> <b>$</b><span id="resumen-total-pagar"></span></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="guardarPDF">Guardar como PDF</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('guardarPDF').addEventListener('click', function() {
            const element = document.getElementById('contenidoFactura');
            const opt = {
                margin:       1,
                filename:     'factura.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { dpi: 192, letterRendering: true },
                jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
            };
            html2pdf().from(element).set(opt).save();
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</body>
</html>
