<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiciosTiempo;
use Carbon\Carbon;

class ServiciosTiempoController extends Controller
{
    // En tu controlador, por ejemplo, en el método que pasa los datos a la vista
    public function index(Request $request)
    {
        $servicios = ServiciosTiempo::where('estado', 'en_curso')->paginate(10);
    
        return view('servicios_tiempo.index', compact('servicios'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'documento' => 'required|string|max:20',
            'telefono' => 'nullable|string|max:20',
            'placa' => 'required|string|max:20',
            'tipo' => 'required|in:Moto,Carro',
        ]);

        // Capturar la fecha y hora actual en la zona horaria de Bogotá
        $fechaHoraIngreso = Carbon::now('America/Bogota');

        ServiciosTiempo::create([
            'nombre' => $request->nombre,
            'documento' => $request->documento,
            'telefono' => $request->telefono,
            'placa' => $request->placa,
            'tipo' => $request->tipo,
            'fecha_hora_ingreso' => $fechaHoraIngreso,
        ]);

        return redirect()->route('servicios_tiempo.index')->with('success', 'Servicio registrado correctamente');
    }

    // En tu archivo ServiciosTiempoController.php
    public function marcarSalida($id)
    {
        // Obtener el servicio por ID
        $servicio = \App\Models\ServiciosTiempo::findOrFail($id);

        // Establecer la hora de salida con la hora actual de Bogotá
        $now = new \DateTime('now', new \DateTimeZone('America/Bogota'));
        $servicio->fecha_hora_salida = $now->format('Y-m-d H:i:s');

        // Calcular el tiempo de estadía
        $entrada = new \DateTime($servicio->fecha_hora_ingreso);
        $intervalo = $entrada->diff($now);

        // Obtener el tipo de vehículo
        $tipo_vehiculo = $servicio->tipo;

        // Calcular el tiempo de estadía en horas
        $horas_estadia = ($intervalo->days * 24) + $intervalo->h;
        if ($intervalo->i > 0) {
            $horas_estadia++; // Si hay minutos, redondeamos a la hora completa siguiente
        }

        // Calcular el tiempo de estadía en formato "X días Y horas"
        if ($horas_estadia >= 24) {
            $dias_estadia = floor($horas_estadia / 24);
            $horas_adicionales = $horas_estadia % 24;

            $tiempo_estadia = $dias_estadia . ' días ' . $horas_adicionales . ' horas';
        } else {
            $tiempo_estadia = $horas_estadia . ' horas ' . $intervalo->i . ' minutos';
        }

        // Definir los precios según el tipo de vehículo
        $precio_por_hora_moto = 1500;
        $precio_por_hora_carro = 3900;
        $precio_por_dia_moto = 4900;
        $precio_por_dia_carro = 15900;

        // Si la estadía es de un día completo o más, calculamos por días
        if ($horas_estadia >= 24) {
            $dias_completos = floor($horas_estadia / 24);
            $horas_adicionales = $horas_estadia % 24;

            if ($tipo_vehiculo == 'Moto') {
                // Si hay horas adicionales, cobramos un día completo más + las horas adicionales
                $total_a_pagar = $dias_completos * $precio_por_dia_moto;
                if ($horas_adicionales > 0) {
                    $total_a_pagar += $horas_adicionales * $precio_por_hora_moto;
                }
            } else {
                $total_a_pagar = $dias_completos * $precio_por_dia_carro;
                if ($horas_adicionales > 0) {
                    $total_a_pagar += $horas_adicionales * $precio_por_hora_carro;
                }
            }
        } else {
            // Si la estadía es menor a 24 horas, calculamos por horas
            if ($tipo_vehiculo == 'Moto') {
                $total_a_pagar = $horas_estadia * $precio_por_hora_moto;
            } else {
                $total_a_pagar = $horas_estadia * $precio_por_hora_carro;
            }
        }

        // Asignar el total a pagar y el tiempo de estadía
        $servicio->total_a_pagar = $total_a_pagar;
        $servicio->tiempo_estadia = $tiempo_estadia;

        // Actualizar el estado a "Salido"
        $servicio->estado = 'terminado'; // Cambiar el estado a "Salido"

        // Guardar los cambios
        $servicio->save();

        // Redirigir con un mensaje de éxito
        return redirect()->back()->with([
            'success' => 'Hora de salida registrada correctamente',
            'mostrar_resumen' => [
                'nombre' => $servicio->nombre,
                'documento' => $servicio->documento,
                'telefono' => $servicio->telefono,
                'placa' => $servicio->placa,
                'tipo' => $servicio->tipo,
                'fecha_ingreso' => $servicio->fecha_hora_ingreso,
                'fecha_salida' => $servicio->fecha_hora_salida,
                'tiempo_estadia' => $servicio->tiempo_estadia,
                'total_a_pagar' => $servicio->total_a_pagar,
            ]
        ]);
    }

    public function historial(Request $request)
    {
        // Obtener el filtro de estado desde la solicitud, por defecto vacío (mostrar todos)
        $estado = $request->get('estado', '');
    
        // Construir la consulta dinámica
        $query = ServiciosTiempo::query();
    
        // Aplicar el filtro de estado si está presente
        if (!empty($estado)) {
            $query->where('estado', $estado);
        }
    
        // Ordenar por fecha de ingreso y paginar los resultados
        $historialServicios = $query->orderBy('fecha_hora_ingreso', 'desc')->paginate(10);
    
        // Retornar la vista con los servicios y el estado actual
        return view('servicios_tiempo.historial', compact('historialServicios', 'estado'));
    }
    
}
