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
                        <div class="form-group d-flex justify-content-between">
                            <button type="submit" class="btn btn-sm btn-primary btn-block-xs-only">
                                <i class="fas fa-save mr-2"></i>Guardar</button>
                            <a href="{{ route('measurers.index') }}" class="btn btn-sm btn-default btn-block-xs-only">
                                <i class="fas fa-hand-point-left mr-2"></i>Regresar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
