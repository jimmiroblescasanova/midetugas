@extends('layouts.main')

@section('header')
    <div class="col-sm-6">
        <h1><i class="fas fa-user"></i> Crear tanque</h1>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('tanks.store') }}" role="form" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="project_id">Seleccionar condominio</label>
                                    <select class="form-control select2bs4 {{ $errors->first('brand') ? 'is-invalid' : '' }}"
                                            name="project_id"
                                            id="project_id">
                                        <option>Selecciona una opción</option>
                                        @foreach ($projects as $id => $project)
                                            <option value="{{ $id }}">{{ $project }}</option>
                                        @endforeach
                                    </select>
                                    {!! $errors->first('project_id', '<div class="invalid-feedback">:message</div>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="brand">Marca</label>
                                    <input type="text"
                                           class="form-control {{ $errors->first('brand') ? 'is-invalid' : '' }}"
                                           name="brand"
                                           id="brand"
                                           value="{{ old('brand') }}">
                                    {!! $errors->first('brand', '<div class="invalid-feedback">:message</div>') !!}
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="model">Modelo</label>
                                    <input type="text"
                                           class="form-control {{ $errors->first('model') ? 'is-invalid' : '' }}"
                                           name="model"
                                           id="model"
                                           value="{{ old('model') }}">
                                    {!! $errors->first('model', '<div class="invalid-feedback">:message</div>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="serial_number">Número de serie</label>
                                    <input type="text"
                                           class="form-control {{ $errors->first('serial_number') ? 'is-invalid' : '' }}"
                                           name="serial_number"
                                           id="serial_number"
                                           value="{{ old('serial_number') }}">
                                    {!! $errors->first('serial_number', '<div class="invalid-feedback">:message</div>') !!}
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="capacity">Capacidad (m3)</label>
                                    <input type="number"
                                           class="form-control {{ $errors->first('capacity') ? 'is-invalid' : '' }}"
                                           name="capacity"
                                           id="capacity"
                                           value="{{ old('capacity') }}">
                                    {!! $errors->first('capacity', '<div class="invalid-feedback">:message</div>') !!}
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block-xs-only">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')

@stop
