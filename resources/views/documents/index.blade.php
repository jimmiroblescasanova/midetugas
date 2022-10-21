@extends('layouts.main')

@section('header')
    <div class="col-sm-6">
        <h1><i class="fas fa-receipt mr-2"></i>Recibos</h1>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            @livewire('tables.documents')
        </div>
    </div>
@stop
