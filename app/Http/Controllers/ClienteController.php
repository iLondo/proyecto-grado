<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Models\Vehiculo;

class ClienteController extends Controller
{
    // Mostrar todos los clientes
    public function index()
    {
        $clientes = Cliente::all();
        $clientes = Cliente::paginate(10);
        return view('clientes.index', compact('clientes'));

        $clientes = Cliente::with('vehiculos')->get();
        return view('clientes.index', compact('clientes'));
    }

    // Mostrar el formulario para crear un nuevo cliente
    public function create()
    {
        return view('clientes.create');
    }

    // Almacenar un nuevo cliente
    public function store(Request $request)
    {
        // Validar los datos del cliente
        $validated = $request->validate([
            'nombre' => 'required|string',
            'documento' => 'required|string',
            'telefono' => 'required|string',
            'vehiculo.placa' => 'required|string',
            'vehiculo.tipo' => 'required|string',
        ]);

        // Crear el cliente
        $cliente = Cliente::create([
            'nombre' => $validated['nombre'],
            'documento' => $validated['documento'],
            'telefono' => $validated['telefono'],
        ]);

        // Crear el vehículo asociado al cliente
        $cliente->vehiculos()->create([
            'placa' => $validated['vehiculo']['placa'],
            'tipo' => $validated['vehiculo']['tipo'],
        ]);

        return redirect()->route('clientes.index')->with('success', 'Cliente y vehículo registrados exitosamente.');
    }


    // Mostrar los detalles de un cliente
    public function show(Cliente $cliente)
    {
        return view('clientes.show', compact('cliente'));
    }

    // Mostrar el formulario para editar un cliente
    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    // Actualizar los detalles de un cliente
    public function update(Request $request, $id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->update($request->only('nombre', 'documento', 'telefono'));
    
        if ($request->has('vehiculo_id')) {
            $vehiculo = Vehiculo::findOrFail($request->vehiculo_id);
            $vehiculo->update($request->only('placa', 'tipo'));
        }
    
        return redirect()->back()->with('success', 'Datos actualizados correctamente');
    }
    

    // Eliminar un cliente
    // En ClienteController.php
    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->delete();

        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado exitosamente');
    }
}
