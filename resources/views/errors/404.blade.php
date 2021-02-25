@extends('layouts.main')

@section('header')
    <div class="col-sm-6">
        <h1><i class="fas fa-ban"></i> Error 404</h1>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center">
                    <h1>Página no encontrada</h1>
                    <h2>{{ $exception->getMessage() }}</h2>
                    <button class="btn btn-default" onclick="history.back();"><i class="fas fa-undo"></i> Atrás</button>
                    <a class="btn btn-danger" href=""><i class="fas fa-bug"></i> Reportar error</a>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')

@stop
