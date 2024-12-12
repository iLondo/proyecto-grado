<?php

namespace App\Http\Controllers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\Cliente;
use App\Models\Mensualidad;
use App\Models\ServiciosTiempo;
use App\Http\Controllers\Controller;
use DateTime;


class ExportController extends Controller
{
    public function exportarClientesConVehiculos()
    {
        $spreadsheet = new Spreadsheet();
        $clientes = Cliente::with('vehiculos')->get();
        $sheet = $spreadsheet->getActiveSheet();

        // Establecer los encabezados
        $sheet->setCellValue('A1', 'Nombre Cliente');
        $sheet->setCellValue('B1', 'Vehículo');
        $sheet->setCellValue('C1', 'Placa');

        // Aplicar estilos a los encabezados
        $sheet->getStyle('A1:D1')->getFont()->setBold(true)->getColor()->setARGB('FFFFFF');
        $sheet->getStyle('A1:D1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('1DAAE2');
        $sheet->getStyle('A1:D1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        // Ajustar el ancho de las columnas automáticamente
        foreach (range('A', 'D') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Insertar los datos de los clientes
        $row = 2;
        foreach ($clientes as $cliente) {
            foreach ($cliente->vehiculos as $vehiculo) {
                $sheet->setCellValue('A' . $row, $cliente->nombre);
                $sheet->setCellValue('B' . $row, $vehiculo->tipo);
                $sheet->setCellValue('C' . $row, $vehiculo->placa);
                $row++;
            }

            // Si el cliente no tiene vehículos
            if ($cliente->vehiculos->isEmpty()) {
                $sheet->setCellValue('A' . $row, $cliente->nombre);
                $sheet->setCellValue('B' . $row, 'N/A');
                $sheet->setCellValue('C' . $row, 'N/A');
                $sheet->setCellValue('D' . $row, 'N/A');
                $row++;
            }
        }

        // Crear el escritor para el archivo Excel
        $writer = new Xlsx($spreadsheet);
        $filename = 'clientes_con_vehiculos.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    public function exportarServiciosTiempo()
    {
        $spreadsheet = new Spreadsheet();
        $servicios = ServiciosTiempo::with('cliente', 'vehiculo')->get();
        $sheet = $spreadsheet->getActiveSheet();

        // Establecer los encabezados
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Nombre Cliente');
        $sheet->setCellValue('C1', 'Documento Cliente');
        $sheet->setCellValue('D1', 'Teléfono Cliente');
        $sheet->setCellValue('E1', 'Placa Vehículo');
        $sheet->setCellValue('F1', 'Tipo Vehículo');
        $sheet->setCellValue('G1', 'Fecha Ingreso');
        $sheet->setCellValue('H1', 'Fecha Salida');
        $sheet->setCellValue('I1', 'Tiempo Estadia');
        $sheet->setCellValue('J1', 'Total a Pagar');
        $sheet->setCellValue('K1', 'Estado');
        $sheet->setCellValue('L1', 'Fecha Creación');
        $sheet->setCellValue('M1', 'Fecha Actualización');

        // Aplicar estilos a los encabezados
        $sheet->getStyle('A1:M1')->getFont()->setBold(true)->getColor()->setARGB('FFFFFF');
        $sheet->getStyle('A1:M1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('1DAAE2');
        $sheet->getStyle('A1:M1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Ajustar el ancho de las columnas automáticamente
        foreach (range('A', 'M') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Insertar los datos de los servicios
        $row = 2;
        foreach ($servicios as $servicio) {
            $sheet->setCellValue('A' . $row, $servicio->id);
            $sheet->setCellValue('B' . $row, $servicio->nombre);
            $sheet->setCellValue('C' . $row, $servicio->documento);
            $sheet->setCellValue('D' . $row, $servicio->telefono);
            $sheet->setCellValue('E' . $row, $servicio->placa);
            $sheet->setCellValue('F' . $row, $servicio->tipo);
            $sheet->setCellValue('G' . $row, $servicio->fecha_hora_ingreso ? (new DateTime($servicio->fecha_hora_ingreso))->format('Y-m-d H:i:s') : '');
            $sheet->setCellValue('H' . $row, $servicio->fecha_hora_salida ? (new DateTime($servicio->fecha_hora_salida))->format('Y-m-d H:i:s') : '');
            $sheet->setCellValue('I' . $row, $servicio->tiempo_estadia);
            $sheet->setCellValue('J' . $row, $servicio->total_a_pagar);
            $sheet->setCellValue('K' . $row, $servicio->estado);
            $sheet->setCellValue('L' . $row, (new DateTime($servicio->created_at))->format('Y-m-d H:i:s'));
            $sheet->setCellValue('M' . $row, (new DateTime($servicio->updated_at))->format('Y-m-d H:i:s'));
            $row++;
        }

        // Crear el escritor para el archivo Excel
        $writer = new Xlsx($spreadsheet);
        $filename = 'servicios_tiempo.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    public function exportarMensualidades()
    {
        $mensualidades = Mensualidad::with('cliente', 'vehiculo')->get();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Establecer los encabezados
        $sheet->setCellValue('A1', 'Nombre Cliente');
        $sheet->setCellValue('B1', 'Fecha de Inicio');
        $sheet->setCellValue('C1', 'Fecha de Fin');
        $sheet->setCellValue('D1', 'Monto');
        $sheet->setCellValue('E1', 'Fecha de Creación');
        $sheet->setCellValue('F1', 'Fecha de Actualización');
        $sheet->setCellValue('G1', 'Placa Vehículo');
        $sheet->setCellValue('H1', 'Tipo Vehículo');
        $sheet->setCellValue('I1', 'Estado');
        $sheet->setCellValue('J1', 'Valor Pagado');
        $sheet->setCellValue('K1', 'Fecha de Pago');

        // Aplicar estilos a los encabezados
        $sheet->getStyle('A1:K1')->getFont()->setBold(true)->getColor()->setARGB('FFFFFF');
        $sheet->getStyle('A1:K1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('1DAAE2');
        $sheet->getStyle('A1:K1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Ajustar el ancho de las columnas automáticamente
        foreach (range('A', 'K') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Insertar los datos de las mensualidades
        $row = 2;
        foreach ($mensualidades as $mensualidad) {
            $sheet->setCellValue('A' . $row, $mensualidad->cliente ? $mensualidad->cliente->nombre : 'N/A');
            $sheet->setCellValue('B' . $row, (new \DateTime($mensualidad->fecha_inicio))->format('Y-m-d'));
            $sheet->setCellValue('C' . $row, (new \DateTime($mensualidad->fecha_fin))->format('Y-m-d'));
            $sheet->setCellValue('D' . $row, $mensualidad->monto);
            $sheet->setCellValue('E' . $row, (new \DateTime($mensualidad->created_at))->format('Y-m-d H:i:s'));
            $sheet->setCellValue('F' . $row, (new \DateTime($mensualidad->updated_at))->format('Y-m-d H:i:s'));
            $sheet->setCellValue('G' . $row, $mensualidad->vehiculo ? $mensualidad->vehiculo->placa : 'N/A');
            $sheet->setCellValue('H' . $row, $mensualidad->vehiculo ? $mensualidad->vehiculo->tipo : 'N/A');
            $sheet->setCellValue('I' . $row, $mensualidad->estado);
            $sheet->setCellValue('J' . $row, $mensualidad->valor_pago);
            $sheet->setCellValue('K' . $row, (new \DateTime($mensualidad->fecha_pago))->format('Y-m-d H:i:s'));
            $row++;
        }

        // Crear el escritor para el archivo Excel
        $writer = new Xlsx($spreadsheet);
        $filename = 'informe_mensualidades.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }
}
