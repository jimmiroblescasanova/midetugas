@extends('layouts.main')

@section('header')
    <div class="col-sm-6">
        <h1><i class="fas fa-users"></i> Clientes</h1>
    </div>
    @can('create_clients')
        <div class="col-sm-6 text-right">
            <a href="{{ route('clients.export') }}" class="btn btn-sm btn-default">
                <i class="fas fa-download mr-2"></i>Exportar</a>
            <button type="button" data-toggle="modal" data-target="#importarClientesModal" class="btn btn-sm btn-default">
                <i class="fas fa-upload mr-2"></i>Importar</button>
            <a href="{{ route('clients.create') }}" class="btn btn-primary btn-sm btn-block-xs-only">
                <i class="fas fa-pencil-alt mr-2"></i>Crear nuevo</a>
        </div>
    @endcan
@stop

@section('content')
<div class="row">
    <div class="col-12">
        @livewire('tables.clients')
    </div>
</div>
@stop

@section('modal-section')
    @livewire('imports.clients')
@stop
