@extends('layouts.main')

@section('header')
    <div class="col-sm-6">
        <h1><i class="fas fa-user"></i> Editar medidor</h1>
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
                        <div class="row">
                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-sm btn-primary btn-block-xs-only"><i class="fas fa-save"></i> Guardar</button>
                            </div>
                            <div class="col-sm-6">
                                <a href="{{ route('measurers.index') }}" class="btn btn-sm btn-danger btn-block-xs-only float-sm-right"><i class="fas fa-hand-point-left"></i> Regresar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')

@stop
