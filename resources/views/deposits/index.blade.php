@extends('layouts.main')

@section('title', 'Depósitos')

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
            @livewire('tables.deposits')
        </div>
    </div>
@stop
