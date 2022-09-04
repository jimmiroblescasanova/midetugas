@extends('layouts.main')

@section('header')
    <div class="col-sm-6">
        <h1><i class="fas fa-user mr-2"></i>Depósitos</h1>
    </div>
    <div class="col-sm-6">
        <a href="{{ route('deposits.create') }}" class="btn btn-primary btn-sm float-sm-right btn-block-xs-only">
            <i class="fas fa-pencil-alt mr-2"></i>Nuevo depósito
        </a>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Folio</th>
                                <th>Fecha</th>
                                <th>Nombre</th>
                                <th>Total</th>
                                <th>Imprimir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($deposits as $deposit)
                                <tr>
                                    <td>{{ $deposit->id }}</td>
                                    <td>{{ $deposit->date->format('d-m-Y') }}</td>
                                    <td>
                                        {{ $deposit->client->name }}
                                        @if (!$deposit->active)
                                            <span class="badge badge-danger">cancelado</span>
                                        @endif
                                    </td>
                                    <td>{{ $deposit->total }}</td>
                                    <td class="text-right">
                                        <a href="{{ route('deposits.show', $deposit) }}" class="btn btn-default btn-xs"
                                            target="_blank"><i class="fas fa-print mr-2"></i>Imprimir</a>
                                        @if ($deposit->active)
                                            <a href="{{ route('deposits.cancel', $deposit) }}"
                                                class="btn btn-danger btn-xs mr-2">
                                                <i class="fas fa-ban mr-2"></i>Cancelar</a>
                                        @endif
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
