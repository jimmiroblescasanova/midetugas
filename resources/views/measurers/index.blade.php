@extends('layouts.main')

@section('header')
    <div class="col-sm-6">
        <h1><i class="fas fa-tachometer-alt"></i> Medidores</h1>
    </div>
    <div class="col-sm-6">
        <a href="{{ route('measurers.create') }}" class="btn btn-primary btn-sm float-sm-right">Crear nuevo</a>
    </div>
@stop

@section('alert')
    @include('partials.alerts.danger')
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body table-responsive">
                    <table id="dataTableMeasurers" class="table table-striped">
                        <thead>
                        <tr>
                            <th>Clave</th>
                            <th>Modelo</th>
                            <th>No. serie</th>
                            <th>Estado</th>
                            <th>Acción</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($measurers as $measurer)
                            <tr>
                                <td>{{ $measurer->code }}</td>
                                <td>{{ $measurer->model }}</td>
                                <td>{{ $measurer->serial_number }}</td>
                                <td>{!! setBadge($measurer->active) !!}</td>
                                <td class="float-sm-right">
                                    <button type="button" class="btn btn-danger btn-xs delete"
                                            data-id="{{ $measurer->id }}"><i class="fas fa-trash"></i> Eliminar
                                    </button>
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
    <div class="modal fade" id="modalDelete">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">¿Estás seguro?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {{--<div class="modal-body">
                    <span id="showModalContent"></span>
                </div>--}}
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <form action="{{ route('measurers.destroy') }}" method="POST">
                        @csrf @method('delete')
                        <input type="hidden" id="deleteMeasurerInput" name="id" value="">
                        <button type="submit" class="btn btn-danger">Si, seguro!</button>
                    </form>
                </div>
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
            $('#dataTableMeasurers').DataTable({
                "responsive": true,
                "autoWidth": false,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
                },
            });

            $('.delete').on('click', function (e) {
                e.preventDefault();
                $('#deleteMeasurerInput').val($(this).data('id'));
                $('#modalDelete').modal();

                /*const token = $('meta[name="csrf-token"]').attr('content');
                const route = "";
                $.ajax({
                    type: 'POST',
                    url: route,
                    headers: {'X-CSRF-TOKEN': token},
                    data: {
                        id: id,
                    },
                    dataType: 'json',
                    success: function (response) {
                        console.log(response);
                        let data = response.data;
                        $('span#showModalContent').html(data.model);
                    },
                    error: function (response) {
                        console.log('Error: ' + response);
                    },
                });*/
            });


        });
    </script>
@stop
