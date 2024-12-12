<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\ServiciosTiempoController;
use App\Http\Controllers\GestionDiariaController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MensualidadController;
use App\Models\Cliente;
use App\Models\Vehiculo;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/informes', function () {
    return view('informes.index');
});

Route::get('/reportes', function () {
    return view('reportes.index');
});

Route::get('/clientes/mensualidades', function () {
    return view('clientes.mensualidades');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::resource('clientes', ClienteController::class);
Route::resource('vehiculos', VehiculoController::class);
Route::resource('gestion_diaria', GestionDiariaController::class);

Route::put('/vehiculos/{id}', [VehiculoController::class, 'update'])->name('vehiculos.update');
Route::resource('servicios_tiempo', ServiciosTiempoController::class);
// Ruta para mostrar el formulario de registro de nuevo servicio
Route::get('/servicios_tiempo/create', [ServiciosTiempoController::class, 'create'])->name('servicios_tiempo.create');

// Ruta para almacenar el nuevo servicio
Route::post('/servicios_tiempo/store', [ServiciosTiempoController::class, 'store'])->name('servicios_tiempo.store');
Route::get('/servicios_tiempo', [ServiciosTiempoController::class, 'index'])->name('servicios_tiempo.index');
// En tu archivo routes/web.php
Route::post('/servicios_tiempo/{id}/marcar_salida', [ServiciosTiempoController::class, 'marcarSalida'])->name('servicios_tiempo.marcar_salida');

Route::get('/servicos_tiempo/index', [ServiciosTiempoController::class, 'serviciosSalidos'])->name('servicios.salidos');

Route::get('/clientes/{id}', function ($id) {
    $cliente = \App\Models\Cliente::find($id);
    return response()->json($cliente);
});


Route::delete('/clientes/{cliente}', [ClienteController::class, 'destroy'])->name('clientes.destroy');
Route::get('/clientes/{clienteId}/vehiculos', [ClienteController::class, 'obtenerVehiculos']);

Route::get('/search-clients', function (Request $request) {
    $query = $request->get('query');
    $clients = Cliente::where('nombre', 'like', "%$query%")
        ->orWhere('documento', 'like', "%$query%")
        ->get();
    return response()->json($clients);
});

Route::get('/get-vehicles/{cliente_id}', function ($cliente_id) {
    $vehiculos = Vehiculo::where('cliente_id', $cliente_id)->get();
    return response()->json($vehiculos);
});

Route::get('export-clientes-vehiculos', [ExportController::class, 'exportarClientesConVehiculos']);
Route::get('export-servicios-tiempo', [ExportController::class, 'exportarServiciosTiempo']);
Route::get('export-mensualidades', [ExportController::class, 'exportarMensualidades']);


Route::get('/grafico_servicios', [DashboardController::class, 'index'])->name('grafico.servicios');
Route::get('/grafico_clientes', [DashboardController::class, 'informeClientes'])->name('grafico.clientes');
Route::get('/grafico_mensualidades', [DashboardController::class, 'informeMensualidades'])->name('grafico.mensualidades');

Route::get('/mensualidades', [MensualidadController::class, 'index'])->name('mensualidades.index');
Route::post('/mensualidades', [MensualidadController::class, 'store'])->name('mensualidades.store');
Route::post('/mensualidades/registrar-pago', [MensualidadController::class, 'registrarPago'])->name('mensualidades.registrarPago');
Route::put('/mensualidades/{id}/cancelar', [MensualidadController::class, 'cancelarMensualidad'])->name('mensualidades.cancelar');

Route::get('/historial-servicios', [ServiciosTiempoController::class, 'historial'])->name('historial.servicios');