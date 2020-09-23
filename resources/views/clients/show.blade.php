@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
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
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-four-tabContent">
                            <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel"
                                 aria-labelledby="custom-tabs-four-home-tab">
                                <form action="{{ route('clients.update', $client) }}" role="form" method="POST">
                                    @csrf
                                    @method('patch')
                                    @include('partials.forms.client')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button class="btn btn-sm btn-primary" type="submit">Actualizar</button>
                                        </div>
                                        <div class="col-md-6">
                                            <button class="btn btn-sm btn-danger float-sm-right" type="button" onclick="history.back()">Atrás</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel"
                                 aria-labelledby="custom-tabs-four-profile-tab">
                                <form action="{{ route('contacts.update', $client) }}" role="form" method="POST">
                                    @csrf
                                    @method('patch')
                                    @include('partials.forms.contacts')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button class="btn btn-sm btn-primary" type="submit">Actualizar</button>
                                        </div>
                                        <div class="col-md-6">
                                            <button class="btn btn-sm btn-danger float-sm-right" type="button" onclick="history.back()">Atrás</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="custom-tabs-four-messages" role="tabpanel"
                                 aria-labelledby="custom-tabs-four-messages-tab">
                                <form action="{{ route('address.update') }}" role="form" method="POST">
                                    @csrf
                                    @method('patch')
                                    @include('partials.forms.address')
                                    <input type="hidden" name="client_id" value="{{ $client->id }}">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button class="btn btn-sm btn-primary" type="submit">Actualizar</button>
                                        </div>
                                        <div class="col-md-6">
                                            <button class="btn btn-sm btn-danger float-sm-right" type="button" onclick="history.back()">Atrás</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@stop
