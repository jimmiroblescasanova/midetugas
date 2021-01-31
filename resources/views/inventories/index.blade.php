@extends('layouts.main')

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
                <div class="card-body">
                    <table class="table" id="dataTableInventories">
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
                                <td>{{ $inventory->tank->brand . ' - ' . $inventory->tank->model . ' - ' . $inventory->tank->serial_number }}</td>
                                <td>{{ $inventory->quantity }} L</td>
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
    <script>
        $(document).ready(function () {
            $('#dataTableInventories').DataTable({
                "responsive": true,
                "autoWidth": false,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
                },
            });
        });
    </script>
@stop
