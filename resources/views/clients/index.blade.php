@extends('layouts.main')

@section('header')
    <div class="col-sm-6">
        <h1><i class="fas fa-users"></i> Clientes</h1>
    </div>
    <div class="col-sm-6">
        <a href="{{ route('clients.create') }}" class="btn btn-primary btn-sm float-sm-right btn-block-xs-only">
            <i class="fas fa-pencil-alt"></i> Crear nuevo</a>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-responsive">
                    <table id="dataTableClients" class="table table-striped">
                        <thead>
                        <tr>
                            <th>Número de cuenta</th>
                            <th>Nombre completo</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Acción</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($clients as $client)
                            <tr>
                                <td>{{ $client->id }}</td>
                                <td>{{ $client->name }}</td>
                                <td>{{ $client->email }}</td>
                                <td>{{ $client->phone }}</td>
                                <td class="text-right">
                                    @if (is_null($client->measurer_id))
                                        <button class="btn btn-info btn-xs setMeasurerBtn" data-id="{{ $client->id }}"><i class="fas fa-edit"></i> Asignar medidor</button>
                                    @endif
                                    <a href="{{ route('clients.show', $client) }}" class="btn btn-xs btn-primary"><i class="fas fa-eye"></i> Ver</a>
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

@section('modal-section')
    <div class="modal fade" id="setMeasurerModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Selecciona un medidor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('clients.attach') }}" method="post" role="form">
                    @csrf
                    <input type="hidden" id="client_id" name="client_id" value="">
                    <div class="modal-body">
                        <label for="measurer_id" class="sr-only">Medidor</label>
                        <select class="form-control select2bs4" name="measurer_id" id="measurer_id">
                            @foreach ($measurers as $measurer)
                                <option value="{{ $measurer->id }}">{{ $measurer->serial_number }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Asignar</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
@stop

@section('scripts')
    <script>
        $(document).ready(function () {
            $('#dataTableClients').DataTable({
                "responsive": true,
                "autoWidth": false,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
                },
            });

            $('.setMeasurerBtn').on('click', function (e){
                e.preventDefault();
                $('#client_id').val($(this).data('id'));
                $('#setMeasurerModal').modal();
            });
        });
    </script>
@stop
