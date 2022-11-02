@extends('layouts.main')

@section('title', 'Crear clientes - dirección')

@section('header')
    <div class="col-sm-6">
        <h1><i class="fas fa-users"></i> Nuevo cliente</h1>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <nav class="nav nav-pills nav-justified">
                        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Paso 1. Datos
                            generales</a>
                        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Paso 2.
                            Contactos</a>
                        <a class="nav-link active" href="#">Paso 3. Direcciones</a>
                    </nav>
                </div>
                <div class="card-body">
                    <div class="">
                        <p class="lead mb-3">Capturar información de la dirección</p>
                    </div>

                    <form action="{{ route('address.update', $client) }}" role="form" method="POST">
                        @csrf
                        @method('patch')
                        @include('clients.forms.address')
                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-sm btn-primary btn-block-xs-only"><i class="fas fa-save"></i> Guardar y
                                    terminar
                                </button>
                            </div>
                            <div class="col-md-6">
                                <a class="btn btn-sm btn-danger float-sm-right btn-block-xs-only"
                                   href="{{ route('clients.index') }}"><i class="fas fa-hand-point-right"></i> Capturar después</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
