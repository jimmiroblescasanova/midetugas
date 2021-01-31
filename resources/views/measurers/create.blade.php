@extends('layouts.main')

@section('header')
    <div class="col-sm-6">
        <h1>Alta de medidor</h1>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form role="form" action="{{ route('measurers.store') }}" method="POST">
                        @csrf
                        @include('measurers._form')
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="actual_measure">Consumo actual (m3)</label>
                                    <input type="text"
                                           class="form-control {{ $errors->first('actual_measure') ? 'is-invalid' : '' }}"
                                           name="actual_measure"
                                           id="actual_measure"
                                           placeholder="Consumo actual"
                                           value="">
                                    {!! $errors->first('actual_measure', '<div class="invalid-feedback">:message</div>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-sm btn-primary btn-block-xs-only"><i class="fas fa-save"></i> Guardar</button>
                            </div>
                            <div class="col-sm-6">
                                <button type="button" onclick="history.back();" class="btn btn-sm btn-danger btn-block-xs-only float-sm-right"><i class="fas fa-hand-point-left"></i> Cancelar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
