@extends('layouts.main')

@section('header')
    <div class="col-sm-6">
        <h1><i class="fas fa-user mr-2"></i>Tanques</h1>
    </div>
    @can('create_tanks')
        <div class="col-sm-6">
            <a href="{{ route('tanks.create') }}" class="btn btn-primary btn-sm float-sm-right btn-block-xs-only">
                <i class="fas fa-pencil-alt mr-2"></i>Crear nuevo
            </a>
        </div>
    @endcan
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="table" id="dataTableTanks">
                        <thead>
                            <tr>
                                <th>Marca</th>
                                <th>Modelo</th>
                                <th>Numero de serie</th>
                                <th>Capacidad</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tanks as $tank)
                                <tr>
                                    <td>{{ $tank->brand }}</td>
                                    <td>{{ $tank->model }}</td>
                                    <td>{{ $tank->serial_number }}</td>
                                    <td>{{ $tank->capacity }} L</td>
                                    <td>
                                        <a href="{{ route('tanks.edit', $tank) }}" class="btn btn-xs btn-default">
                                            <i class="fas fa-edit mr-2"></i>Editar</a>
                                    </td>
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
        $(document).ready(function() {
            $('#dataTableTanks').DataTable({
                "responsive": true,
                "autoWidth": false,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
                },
            });
        });
    </script>
@stop
