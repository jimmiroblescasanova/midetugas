@extends('layouts.main')

@section('header')
    <div class="col-sm-6">
        <h1><i class="fas fa-hand-holding-usd"></i> Pagos</h1>
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
                            <th>Recibo pagado</th>
                            <th>Importe</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($payments as $pay)
                            <tr>
                                <td>{{ $pay->id }}</td>
                                <td>{{ $pay->client->name }}</td>
                                <td>{{ $pay->date->format('d-m-Y') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('documents.show', $pay->document_id) }}">{{ $pay->document_id }}</a>
                                </td>
                                <td class="text-right">$ {{ $pay->amount }}</td>
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
            $('#dataTablePayments').DataTable({
                "responsive": true,
                "autoWidth": false,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
                },
            });
        });
    </script>
@stop
