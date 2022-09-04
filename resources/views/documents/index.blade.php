@extends('layouts.main')

@section('header')
    <div class="col-sm-6">
        <h1><i class="fas fa-receipt mr-2"></i>Recibos</h1>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table" id="dataTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Periodo</th>
                                <th>Total</th>
                                <th>Pendiente</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($documents as $document)
                                <tr>
                                    <td>{{ $document->id }}</td>
                                    <td>{{ $document->client->name }}</td>
                                    <td>{{ $document->period }}</td>
                                    <td class="text-center">$ {{ $document->total }}</td>
                                    <td class="text-center">$ {{ $document->pending }}</td>
                                    <td class="text-center">{!! status($document->status) !!}</td>
                                    <td class="text-right">
                                        <a href="{{ route('documents.show', $document) }}" class="btn btn-xs btn-primary">
                                            <i class="fas fa-eye mr-2"></i>Revisar / Ver</a>
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
            $('#dataTable').DataTable({
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
