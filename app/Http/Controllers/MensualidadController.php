<?php

namespace App\Http\Controllers;

use App\Models\Mensualidad;
use App\Models\Cliente;
use App\Models\Vehiculo;
use Illuminate\Http\Request;

class MensualidadController extends Controller
{
    /**
     * Muestra una lista de mensualidades pendientes.
     */
    public function index()
    {
        // Usamos paginate(10) para obtener 10 registros por página
        $mensualidades = Mensualidad::with(['cliente', 'vehiculo'])
            ->where('estado', 'pendiente')
            ->paginate(10); // Paginación de 10 elementos

        $clientes = Cliente::all();
        $vehiculos = Vehiculo::all();

        return view('mensualidades.index', compact('mensualidades', 'clientes', 'vehiculos'));
    }    

    /**
     * Almacena una nueva mensualidad.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'vehiculo_id' => 'required|exists:vehiculos,id',
            'fecha_inicio' => 'required|date|before:fecha_fin',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'monto' => 'required|numeric|min:0|max:99999999.99',
        ]);

        try {
            Mensualidad::create([
                'cliente_id' => $validated['cliente_id'],
                'vehiculo_id' => $validated['vehiculo_id'],
                'fecha_inicio' => $validated['fecha_inicio'],
                'fecha_fin' => $validated['fecha_fin'],
                'monto' => $validated['monto'],
                'estado' => 'pendiente',
            ]);

            return redirect()->route('mensualidades.index')
                ->with('success', 'Mensualidad registrada correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Ocurrió un error al registrar la mensualidad: ' . $e->getMessage());
        }
    }

    /**
     * Registra el pago de una mensualidad.
     */
    public function registrarPago(Request $request)
    {
        $validated = $request->validate([
            'mensualidad_id' => 'required|exists:mensualidades,id',
            'valor_pago' => 'required|numeric|min:0',
            'fecha_pago' => 'required|date',
        ]);

        try {
            $mensualidad = Mensualidad::findOrFail($validated['mensualidad_id']);
            
            // Actualización manual para más control
            $mensualidad->valor_pago = $validated['valor_pago'];
            $mensualidad->fecha_pago = $validated['fecha_pago'];
            $mensualidad->estado = 'pagado';
            $mensualidad->save();

            return redirect()->route('mensualidades.index')
                ->with('success', 'Pago registrado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Ocurrió un error al registrar el pago: ' . $e->getMessage());
        }
    }

    /**
     * Cancela una mensualidad.
     */
    public function cancelarMensualidad($id)
    {
        try {
            $mensualidad = Mensualidad::findOrFail($id);
            $mensualidad->update(['estado' => 'cancelado']);

            return redirect()->route('mensualidades.index')
                ->with('success', 'Mensualidad cancelada con éxito.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Ocurrió un error al cancelar la mensualidad: ' . $e->getMessage());
        }
    }
}