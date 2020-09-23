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
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="code">Código</label>
                                    <input type="text"
                                           class="form-control {{ $errors->first('code') ? 'is-invalid' : '' }}"
                                           name="code"
                                           id="code"
                                           placeholder="Código">
                                    {!! $errors->first('code', '<div class="invalid-feedback">:message</div>') !!}
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="serial_number">Número de serie</label>
                                    <input type="text"
                                           class="form-control {{ $errors->first('serial_number') ? 'is-invalid' : '' }}"
                                           name="serial_number"
                                           id="serial_number"
                                           placeholder="Número de serie">
                                    {!! $errors->first('serial_number', '<div class="invalid-feedback">:message</div>') !!}
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="model">Modelo</label>
                                    <input type="text"
                                           class="form-control {{ $errors->first('model') ? 'is-invalid' : '' }}"
                                           name="model"
                                           id="model"
                                           placeholder="Modelo">
                                    {!! $errors->first('model', '<div class="invalid-feedback">:message</div>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <button class="btn btn-primary btn-sm" type="submit">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
