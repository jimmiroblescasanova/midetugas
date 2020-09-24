@extends('layouts.main')

@section('header')
    <div class="col-sm-6">
        <h1><i class="fas fa-receipt"></i> Recibos</h1>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Consumo</th>
                            <th>Total</th>
                            <th>Pendiente</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($documents as $document)
                            <tr>
                                <td>{{ $document->id }}</td>
                                <td>{{ $document->client->name }}</td>
                                <td>{{ $document->month_quantity }} m3</td>
                                <td>$ {{ $document->total }}</td>
                                <td>$ {{ $document->pending }}</td>
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
