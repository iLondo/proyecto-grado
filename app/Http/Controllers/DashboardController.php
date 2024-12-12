<?php

namespace App\Http\Controllers;

use App\Models\ServiciosTiempo;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Vehiculo;
use App\Models\Mensualidad;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Obtener las fechas desde el request
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');
        $estado = $request->input('estado');
    
        // Consulta base
        $query = ServiciosTiempo::query();
    
        // Aplicar filtros si se proporcionaron
        if ($fechaInicio) {
            $query->whereDate('fecha_hora_ingreso', '>=', $fechaInicio);
        }
    
        if ($fechaFin) {
            $query->whereDate('fecha_hora_salida', '<=', $fechaFin);
        }
    
        if ($estado) {
            $query->where('estado', $estado);
        }
    
        // Estadísticas generales
        $cantidadServicios = $query->count();
        $totalIngresos = $query->sum('total_a_pagar');
        $promedioTiempoEstadia = $query->average('tiempo_estadia');
    
        // Datos para gráficos
        $ingresosPorDia = $query
            ->selectRaw('DATE(fecha_hora_ingreso) as fecha, SUM(total_a_pagar) as total')
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->get();
    
        $serviciosPorEstado = $query
            ->selectRaw('estado, COUNT(*) as total')
            ->groupBy('estado')
            ->get();
    
        return view('informes.grafico_servicios', compact(
            'cantidadServicios',
            'totalIngresos',
            'promedioTiempoEstadia',
            'ingresosPorDia',
            'serviciosPorEstado'
        ));
    }

    public function informeClientes(Request $request)
    {
        // Obtener las fechas desde el request
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');

        // Consultar clientes con filtro de fechas
        $clientesQuery = Cliente::query();
        if ($fechaInicio && $fechaFin) {
            $clientesQuery->whereBetween('created_at', [$fechaInicio, $fechaFin]);
        }
        $clientes = $clientesQuery->get();

        // Estadísticas
        $cantidadClientes = $clientesQuery->count();
        $cantidadVehiculos = Vehiculo::count();
        $cantidadVehiculosCarro = Vehiculo::where('tipo', 'carro')->count();
        $cantidadVehiculosMoto = Vehiculo::where('tipo', 'moto')->count();

        // Fechas de registro de clientes
        $fechasRegistroClientes = $clientesQuery->select(DB::raw('DATE(created_at) as fecha_registro'), DB::raw('count(*) as total'))
            ->groupBy('fecha_registro')
            ->get();

        return view('informes.grafico_clientes', compact(
            'clientes',
            'cantidadClientes',
            'cantidadVehiculos',
            'cantidadVehiculosCarro',
            'cantidadVehiculosMoto',
            'fechasRegistroClientes',
            'fechaInicio',
            'fechaFin'
        ));
    }

    public function informeMensualidades(Request $request)
    {
        // Obtener las fechas desde el request
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');
        
        // Consultar mensualidades con filtro de fechas y estado "Pagado"
        $mensualidadesQuery = Mensualidad::where('estado', 'Pagado');
        if ($fechaInicio && $fechaFin) {
            $mensualidadesQuery->whereBetween('fecha_pago', [$fechaInicio, $fechaFin]);
        }
        $mensualidades = $mensualidadesQuery->get();
        
        // Calcular ingresos por tipo de vehículo
        $ingresosMotos = (clone $mensualidadesQuery) // Clonamos la consulta
            ->whereHas('vehiculo', function ($query) {
                $query->where('tipo', 'Moto');
            })
            ->sum('valor_pago');
        
        $ingresosCarros = (clone $mensualidadesQuery) // Clonamos nuevamente para evitar interferencias
            ->whereHas('vehiculo', function ($query) {
                $query->where('tipo', 'Carro');
            })
            ->sum('valor_pago');
        
        // Calcular pagos agrupados por mes
        $pagosPorMes = $mensualidadesQuery->selectRaw('MONTH(fecha_pago) as mes, SUM(valor_pago) as total_pagos')
            ->groupByRaw('MONTH(fecha_pago)')
            ->orderByRaw('MONTH(fecha_pago)')
            ->get();
        
        return view('informes.grafico_mensualidades', compact(
            'mensualidades',
            'ingresosMotos',
            'ingresosCarros',
            'pagosPorMes',
            'fechaInicio',
            'fechaFin'
        ));
    }
    
    
}