@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
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

                        <form action="{{ route('address.store') }}" role="form" method="POST">
                            @csrf
                            @include('partials.forms.address')
                            <input type="hidden" name="client_id" value="{{ $id }}">
                            <div class="row">
                                <div class="col-md-6">
                                    <button class="btn btn-sm btn-primary" type="submit">Guardar y terminar</button>
                                </div>
                                <div class="col-md-6">
                                    <a class="btn btn-sm btn-danger float-sm-right" href="{{ route('clients.index') }}">Capturar después</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
