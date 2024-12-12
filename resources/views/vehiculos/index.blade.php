@extends('adminlte::page')

@section('content')
<div class="container">
    <h1>Vehículos</h1>
    <a href="{{ route('vehiculos.create') }}" class="btn btn-primary">Agregar Vehículo</a>
    <table class="table">
        <thead>
            <tr>
                <th>Placa</th>
                <th>Tipo</th>
                <th>Cliente</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($vehiculos as $vehiculo)
            <tr>
                <td>{{ $vehiculo->placa }}</td>
                <td>{{ $vehiculo->tipo }}</td>
                <td>{{ $vehiculo->cliente->nombre }}</td>
                <td>
                    <a href="{{ route('vehiculos.show', $vehiculo->id) }}" class="btn btn-info">Ver</a>
                    <a href="{{ route('vehiculos.edit', $vehiculo->id) }}" class="btn btn-warning">Editar</a>
                    <form action="{{ route('vehiculos.destroy', $vehiculo->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection