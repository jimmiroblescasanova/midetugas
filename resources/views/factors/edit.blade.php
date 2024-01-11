@extends('layouts.main')

@section('title', 'Editar factor de corrección')

@section('header')
    <div class="col-sm-6">
        <h1><i class="fas fa-home mr-2"></i>Editar</h1>
    </div>
    <div class="col-sm-6">
        <button type="button" class="btn btn-sm btn-danger float-right" data-toggle="modal" data-target="#deleteFactorModal">
            <i class="fas fa-trash-alt mr-2"></i>Eliminar
        </button>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{ route('factors.update', $factor) }}" method="POST">
                    <div class="card-body">
                        @csrf 
                        @method('PATCH')
                        <div class="row">
                            <div class="col">
                                <label for="psig">Factor PSIG</label>
                                <div class="input-group mb-3">
                                    <input type="number" step="0.0001" class="form-control" name="psig" id="psig" value="{{ $factor->psig }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text">PSIG</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <label for="value">Valor</label>
                                <input type="number" step="0.0001" class="form-control" name="value" id="value" value="{{ $factor->value }}">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-save mr-2"></i>Actualizar
                        </button>
                        <a href="{{ url()->previous() }}" class="btn btn-default btn-sm float-right">
                            <i class="fas fa-backward mr-2"></i>Atrás
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('modal-section')
    <x-modals.delete id="deleteFactorModal" :action="route('factors.destroy', $factor)" />
@endsection
