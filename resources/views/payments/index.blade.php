@extends('layouts.main')

@section('header')
    <div class="col-sm-6">
        <h1><i class="fas fa-hand-holding-usd"></i> Pagos</h1>
    </div>
    <div class="col-sm-6">
        <button type="button" class="btn btn-primary btn-sm float-sm-right btn-block-xs-only" data-toggle="modal"
            data-target="#new_payment">
            <i class="fas fa-pencil-alt"></i> Crear nuevo</button>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped" id="dataTablePayments">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Fecha</th>
                                <th>Importe</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $pay)
                                <tr>
                                    <td>{{ $pay->id }}</td>
                                    <td>{{ $pay->client->name }}</td>
                                    <td>{{ $pay->date->format('d-m-Y') }}</td>
                                    <td class="text-right">$ {{ number_format($pay->amount, 2) }}</td>
                                    <td class="text-right">
                                        <button data-id="{{ $pay->id }}" class="btn btn-xs btn-danger cancelPayment"><i
                                                class="fas fa-ban"></i> Eliminar</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="new_payment" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Seleccionar cliente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('payments.createForm') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Seleccionar un cliente</label>
                            <select class="form-control" name="client" id="client">
                                @foreach ($clients as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Seleccionar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script>
        $(document).ready(function() {
            const token = $('meta[name="csrf-token"]').attr('content');

            $('.cancelPayment').on('click', function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                let route = "{{ route('payments.delete') }}";
                let tr = $(this).closest('tr');

                $.ajax({
                    type: 'POST',
                    url: route,
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    data: {
                        id: id,
                        _method: 'delete'
                    },
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        tr.hide('slow');
                    },
                    error: function(data) {
                        console.log(data);
                    },
                });
            });

            $('#dataTablePayments').DataTable({
                "order": [0, 'desc'],
                "responsive": true,
                "autoWidth": false,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
                },
            });
        });
    </script>
@stop
