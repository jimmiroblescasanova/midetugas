@extends('layouts.main')

@section('title', 'Todos los medidores')

@section('header')
    <div class="col-sm-6">
        <h1><i class="fas fa-tachometer-alt mr-2"></i>Medidores</h1>
    </div>
    @can('create_measurers')
        <div class="col-sm-6">
            <a href="{{ route('measurers.create') }}" class="btn btn-primary btn-sm btn-block-xs-only float-right">
                <i class="fas fa-pencil-alt mr-2"></i>Crear nuevo</a>
        </div>
    @endcan
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            @livewire('tables.measurers')
        </div>
    </div>
@stop
