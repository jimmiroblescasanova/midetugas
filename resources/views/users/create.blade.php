@extends('layouts.main')

@section('title', 'Nuevo usuario')

@section('header')
    <div class="col-sm-6">
        <h1><i class="fas fa-user mr-2"></i>Crear usuario</h1>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('users.store') }}" role="form" method="POST">
                        @csrf
                        @include('users._form')
                        <div class="form-group d-flex justify-content-between">
                            <button type="submit" class="btn btn-sm btn-primary btn-block-xs-only">
                                <i class="fas fa-save mr-2"></i>Crear usuario</button>
                            <x-buttons.back />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
