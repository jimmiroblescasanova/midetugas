@extends('layouts.main')

@section('action-button')
    <a href="{{ route('clients.create') }}" class="btn btn-primary btn-sm float-sm-right">Crear cliente</a>
@stop

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                            <table class="table table-hover table-sm">
                                <thead>
                                <tr>
                                    <th>Número de cuenta</th>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Teléfono</th>
                                    <th>Acción</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($clients as $client)
                                    <tr>
                                        <td>{{ $client->account_number }}</td>
                                        <td>{{ $client->name }}</td>
                                        <td>{{ $client->email }}</td>
                                        <td>{{ $client->phone }}</td>
                                        <td><a href="{{ route('clients.show', $client) }}" class="btn btn-xs btn-primary float-sm-right"><i class="far fa-search"></i> Ver</a></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
