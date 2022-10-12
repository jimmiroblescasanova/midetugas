@extends('layouts.main')

@section('header')
    <div class="col-sm-6">
        <h1><i class="fas fa-user mr-2"></i>Editar medidor</h1>
    </div>
    <div class="col-sm-6 d-flex justify-content-end">
        <form action="{{ route('measurers.destroy', $measurer) }}" method="POST">
            @csrf @method('delete')
            <button type="submit" class="btn btn-sm btn-danger">
                <i class="fas fa-trash-alt mr-2"></i>Eliminar</button>
        </form>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form role="form" action="{{ route('measurers.update', $measurer) }}" method="POST">
                        @csrf
                        @method('patch')
                        @include('measurers._form')
                        <div class="text-muted text-right">
                            <small>Última modificación: {{ $measurer->updated_at->diffForHumans() }}</small>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <div class="from-group d-flex justify-content-between mb-0">
                        <button type="submit" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit mr-2"></i>Actualizar</button>
                        <a href="{{ route('measurers.index') }}" type="button" class="btn btn-sm btn-danger">
                            <i class="fas fa-hand-point-left mr-2"></i>Cancelar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
