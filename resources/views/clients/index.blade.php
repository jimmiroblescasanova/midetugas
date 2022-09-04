@extends('layouts.main')

@section('header')
    <div class="col-sm-6">
        <h1><i class="fas fa-users mr-2"></i>Clientes</h1>
    </div>
    @can('create_clients')
        <div class="col-sm-6">
            <a href="{{ route('clients.create') }}" class="btn btn-primary btn-sm float-sm-right btn-block-xs-only">
                <i class="fas fa-pencil-alt mr-2"></i>Crear nuevo</a>
        </div>
    @endcan
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body table-responsive">
                    <table id="dataTableClients" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Número de cuenta</th>
                                <th>Nombre completo</th>
                                <th>Email</th>
                                <th>Nombre corto</th>
                                <th>Teléfono</th>
                                <th>Estado</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clients as $client)
                                <tr>
                                    <td>{{ $client->id }}</td>
                                    <td>{{ $client->name }}</td>
                                    <td>{{ $client->email }}</td>
                                    <td>{{ $client->shortName }}</td>
                                    <td>{{ $client->phone }}</td>
                                    <td>{!! !$client->status
                                        ? '<span class="badge badge-success">Activo</span>'
                                        : '<span class="badge badge-warning">Inactivo</span>' !!}</td>
                                    <td class="text-right">
                                        <a href="{{ route('clients.show', $client) }}" class="btn btn-xs btn-primary">
                                            <i class="fas fa-eye mr-2"></i>Ver / Editar</a>
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
            $('#dataTableClients').DataTable({
                "responsive": true,
                "autoWidth": false,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
                },
            });

            /* $('.setMeasurerBtn').on('click', function(e) {
                e.preventDefault();
                $('#client_id').val($(this).data('id'));
                $('#setMeasurerModal').modal();
            }); */
        });
    </script>
@stop
