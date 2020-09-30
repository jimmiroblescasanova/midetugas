@extends('layouts.main')

@section('header')
    <div class="col-sm-6">
        <h1><i class="fas fa-users"></i> Información del cliente</h1>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline card-outline-tabs">
                <div class="card-header p-0 border-bottom-0">
                    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active"
                               id="custom-tabs-four-home-tab"
                               data-toggle="pill"
                               href="#custom-tabs-four-home"
                               role="tab"
                               aria-controls="custom-tabs-four-home"
                               aria-selected="true"
                            >Datos generales</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                               id="custom-tabs-four-profile-tab"
                               data-toggle="pill"
                               href="#custom-tabs-four-profile"
                               role="tab"
                               aria-controls="custom-tabs-four-profile"
                               aria-selected="false"
                            >Información de contactos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                               id="custom-tabs-four-messages-tab"
                               data-toggle="pill"
                               href="#custom-tabs-four-messages"
                               role="tab"
                               aria-controls="custom-tabs-four-messages"
                               aria-selected="false"
                            >Dirección</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                               id="custom-tabs-four-measurers-tab"
                               data-toggle="pill"
                               href="#custom-tabs-four-measurers"
                               role="tab"
                               aria-controls="custom-tabs-four-measurers"
                               aria-selected="false"
                            >Consumos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                               id="custom-tabs-four-actions-tab"
                               data-toggle="pill"
                               href="#custom-tabs-four-actions"
                               role="tab"
                               aria-controls="custom-tabs-four-actions"
                               aria-selected="false"
                            >Acciones</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="custom-tabs-four-tabContent">
                        <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel"
                             aria-labelledby="custom-tabs-four-home-tab">
                            <form action="{{ route('clients.update', $client) }}" role="form" method="POST">
                                @csrf
                                @method('patch')
                                @include('clients.forms.general')
                                @can('edit_clients')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button class="btn btn-sm btn-primary" type="submit">
                                                <i class="fas fa-save"></i> Actualizar</button>
                                        </div>
                                    </div>
                                @endcan
                            </form>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel"
                             aria-labelledby="custom-tabs-four-profile-tab">
                            <form action="{{ route('contacts.update', $client) }}" role="form" method="POST">
                                @csrf
                                @method('patch')
                                @include('clients.forms.contacts')
                                @can('edit_contacts')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button class="btn btn-sm btn-primary" type="submit">
                                                <i class="fas fa-save"></i> Actualizar</button>
                                        </div>
                                    </div>
                                @endcan
                            </form>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-four-messages" role="tabpanel"
                             aria-labelledby="custom-tabs-four-messages-tab">
                            <form action="{{ route('address.update') }}" role="form" method="POST">
                                @csrf
                                @method('patch')
                                @include('clients.forms.address')
                                <input type="hidden" name="client_id" value="{{ $client->id }}">
                                @can('edit_addresses')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button class="btn btn-sm btn-primary" type="submit">
                                                <i class="fas fa-save"></i> Actualizar</button>
                                        </div>
                                    </div>
                                @endcan
                            </form>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-four-measurers" role="tabpanel"
                             aria-labelledby="custom-tabs-four-measurers-tab">
                            <div class="row">
                                Medidor asignado: {{ $client->measurer->serial_number }}
                            </div>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-four-actions" role="tabpanel"
                             aria-labelledby="custom-tabs-four-actions-tab">
                            <div class="row">
                                <div class="col-md-4">
                                    <a href="{{ route('sms', $client->id) }}" class="btn btn-block btn-success mb-3"><i class="fas fa-sms"></i> Enviar SMS prueba</a>
                                </div>
                                <div class="col-md-4">
                                    <a href="{{ route('clients.testEmail', $client->id) }}" class="btn btn-block btn-primary mb-3"><i class="fas fa-envelope"></i> Enviar correo prueba</a>
                                </div>
                                @if (($client->measurer_id != NULL) && (auth()->user()->can('edit_clients')))
                                    <div class="col-md-4">
                                        <a href="{{ route('clients.detach', $client->id) }}" class="btn btn-block btn-info mb-3"><i class="fas fa-tachometer-alt"></i> Des-asociar medidor</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-sm btn-danger float-sm-right" type="button" onclick="history.back()"><i class="fas fa-hand-point-left"></i> Atrás</button>
                </div>
            </div>
        </div>
    </div>
@stop
