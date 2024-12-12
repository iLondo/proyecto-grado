<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use App\Models\Cliente;
use Illuminate\Http\Request;

class VehiculoController extends Controller
{
    // Mostrar todos los vehículos
    public function index()
    {
        $vehiculos = Vehiculo::all();
        return view('vehiculos.index', compact('vehiculos'));
    }

    // Mostrar el formulario para crear un nuevo vehículo
    public function create()
    {
        $clientes = Cliente::all();
        return view('vehiculos.create', compact('clientes'));
    }

    // Almacenar un nuevo vehículo
    public function store(Request $request)
    {
        ($request->all());
    
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'placa' => 'required|string|max:255',
            'tipo' => 'required|string|max:255',
        ]);
    
        // Crear el vehículo
        Vehiculo::create($request->all());
        
    
        return redirect()->route('clientes.index')->with('success', 'Vehículo creado exitosamente.');
    }
    
    // Mostrar los detalles de un vehículo
    public function show(Vehiculo $vehiculo)
    {
        return view('vehiculos.show', compact('vehiculo'));
    }

    // Mostrar el formulario para editar un vehículo
    public function edit(Vehiculo $vehiculo)
    {
        $clientes = Cliente::all();
        return view('vehiculos.edit', compact('vehiculo', 'clientes'));
    }

    // Actualizar los detalles de un vehículo
    public function update(Request $request, $id)
    {
        $vehiculo = Vehiculo::findOrFail($id);

        // Validar los datos si es necesario
        $request->validate([
            'placa' => 'required|string|max:255',
            'tipo' => 'required|string|max:255',
        ]);

        // Actualizar los datos
        $vehiculo->placa = $request->input('placa');
        $vehiculo->tipo = $request->input('tipo');
        $vehiculo->save();

        // Redireccionar con un mensaje de éxito
        return redirect()->back()->with('success', 'Vehículo actualizado correctamente.');
    }


    // Eliminar un vehículo
    public function destroy(Vehiculo $vehiculo)
    {
        $vehiculo->delete();

        return redirect()->route('clientes.index')->with('success', 'Vehículo eliminado exitosamente.');
    }
}
