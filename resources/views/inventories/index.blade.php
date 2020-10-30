@extends('layouts.main')

@section('header')
    <div class="col-sm-6">
        <h1><i class="fas fa-boxes"></i> Inventarios</h1>
    </div>
    <div class="col-sm-6">
        <a href="{{ route('inventories.create') }}" class="btn btn-primary btn-sm float-sm-right btn-block-xs-only">
            <i class="fas fa-pencil-alt"></i> Crear nuevo
        </a>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Condominio</th>
                            <th>Tanque</th>
                            <th>Cantidad</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($inventories as $inventory)
                            <tr>
                                <td>{{ $inventory->date->format('d-m-Y') }}</td>
                                <td>{{ $inventory->project->name }}</td>
                                <td>{{ $inventory->tank->model . ' - ' . $inventory->tank->serial_number }}</td>
                                <td>{{ $inventory->quantity }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')

@stop
