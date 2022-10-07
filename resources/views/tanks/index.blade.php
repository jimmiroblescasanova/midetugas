@extends('layouts.main')

@section('header')
    <div class="col-sm-6">
        <h1><i class="fas fa-user mr-2"></i>Tanques</h1>
    </div>
    @can('create_tanks')
        <div class="col-sm-6">
            <a href="{{ route('tanks.create') }}" class="btn btn-primary btn-sm float-sm-right btn-block-xs-only">
                <i class="fas fa-pencil-alt mr-2"></i>Crear nuevo
            </a>
        </div>
    @endcan
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            @livewire('tables.tanks')
        </div>
    </div>
@stop
