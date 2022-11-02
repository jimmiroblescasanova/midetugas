@extends('layouts.main')

@section('title', 'Inventarios')

@section('header')
    <div class="col-sm-6">
        <h1><i class="fas fa-boxes"></i> Inventarios</h1>
    </div>
    @can('create_inventories')
        <div class="col-sm-6">
            <a href="{{ route('inventories.create') }}" class="btn btn-primary btn-sm float-sm-right btn-block-xs-only">
                <i class="fas fa-pencil-alt"></i> Crear nuevo
            </a>
        </div>
    @endcan
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Fecha de Ingreso</th>
                            <th>Condominio</th>
                            <th>Tanque</th>
                            <th>Cantidad</th>
                            <th><i class="fas fa-tools"></i></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($inventories as $inventory)
                            <tr>
                                <td>{{ $inventory->date->format('d-m-Y') }}</td>
                                <td>{{ $inventory->project->name }}</td>
                                <td>{{ $inventory->tank->brand . ' - ' . $inventory->tank->model . ' - ' . $inventory->tank->serial_number }}</td>
                                <td>{{ $inventory->quantity }} L</td>
                                <td class="text-right"><a href="{{ route('inventories.show', $inventory) }}" class="btn btn-xs btn-default"><i class="fas fa-eye mr-2"></i>Ver</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {{ $inventories->links() }}
                </div>
            </div>
        </div>
    </div>
@stop
