@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <nav class="nav nav-pills nav-justified">
                            <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Paso 1. Datos generales</a>
                            <a class="nav-link active" href="#">Paso 2. Contactos</a>
                            <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Paso 3. Direcciones</a>
                        </nav>
                    </div>
                    <div class="card-body">
                        <div class="">
                            <p class="lead mb-3">Información de los contactos</p>
                        </div>

                        <form action="{{ route('clients.contacts.store') }}" role="form" method="POST">
                            @csrf
{{--                            <input type="hidden" name="id" value="{{ $id }}">--}}
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label for="ref1_name">Contacto 1: Nombre</label>
                                        <input type="text" class="form-control {{ $errors->first('ref1_name') ? 'is-invalid' : '' }}" name="ref1_name" id="ref1_name" placeholder="Nombre completo" value="{{ old('ref1_name') }}">
                                        {!! $errors->first('ref1_name', '<div class="invalid-feedback">:message</div>') !!}
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="ref1_phone">Teléfono</label>
                                        <input type="text" class="form-control {{ $errors->first('ref1_phone') ? 'is-invalid' : '' }}" name="ref1_phone" id="ref1_phone" placeholder="Número de cuenta" value="{{ old('ref1_phone') }}">
                                        {!! $errors->first('ref1_phone', '<div class="invalid-feedback">:message</div>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label for="ref2_name">Contacto 2: Nombre</label>
                                        <input type="text" class="form-control {{ $errors->first('ref2_name') ? 'is-invalid' : '' }}" name="ref2_name" id="ref2_name" placeholder="Nombre completo" value="{{ old('ref2_name') }}">
                                        {!! $errors->first('ref2_name', '<div class="invalid-feedback">:message</div>') !!}
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="ref2_phone">Teléfono</label>
                                        <input type="text" class="form-control {{ $errors->first('ref2_phone') ? 'is-invalid' : '' }}" name="ref2_phone" id="ref2_phone" placeholder="Número de cuenta" value="{{ old('ref2_phone') }}">
                                        {!! $errors->first('ref2_phone', '<div class="invalid-feedback">:message</div>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <button class="btn btn-sm btn-primary" type="submit">Guardar y siguiente</button>
                                </div>
                                <div class="col-md-6">
                                    <a class="btn btn-sm btn-danger float-sm-right" href="{{ route('clients.address.add', $id) }}">Capturar después</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
