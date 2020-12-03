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
                                                <i class="fas fa-save"></i> Actualizar
                                            </button>
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
                                                <i class="fas fa-save"></i> Actualizar
                                            </button>
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
                                                <i class="fas fa-save"></i> Actualizar
                                            </button>
                                        </div>
                                    </div>
                                @endcan
                            </form>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-four-actions" role="tabpanel"
                             aria-labelledby="custom-tabs-four-actions-tab">
                            <div class="row">
                                <p>Saldo actual: {{ ($client->advance_payment>0.01) ? '-'.number_format($client->advance_payment, 2) : '0.00' }}</p>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <a href="{{ route('sms', $client->id) }}" class="btn btn-block btn-success mb-3"><i
                                            class="fas fa-sms"></i> Enviar SMS prueba</a>
                                </div>
                                <div class="col-md-4">
                                    <a href="{{ route('clients.testEmail', $client->id) }}"
                                       class="btn btn-block btn-primary mb-3"><i class="fas fa-envelope"></i> Enviar
                                        correo prueba</a>
                                </div>
                                @if (($client->measurer_id != NULL) && (auth()->user()->can('edit_clients')))
                                    <div class="col-md-4">
                                        <a href="{{ route('clients.detach', $client->id) }}"
                                           class="btn btn-block btn-info mb-3"><i class="fas fa-tachometer-alt"></i>
                                            Des-asociar medidor</a>
                                    </div>
                                @endif
                            </div>
                            <div class="row">
                                @can('change_status')
                                    <div class="col-md-4">
                                        @if($client->status == FALSE)
                                            <a href="{{ route('clients.status', $client) }}"
                                               class="btn btn-block btn-warning mb-3  text-white"><i
                                                    class="fas fa-user-times"></i> Suspender</a>
                                        @else
                                            <a href="{{ route('clients.status', $client) }}"
                                               class="btn btn-block btn-warning mb-3  text-white"><i
                                                    class="fas fa-user-check"></i> Activar</a>
                                        @endif
                                    </div>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-sm btn-danger float-sm-right" type="button" onclick="history.back()"><i
                            class="fas fa-hand-point-left"></i> Atrás
                    </button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('modal-section')
    <div class="modal fade" id="newPriceModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Suspender cliente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                <label class="form-check-label" for="exampleCheck1">Incluir cargo por reconexión</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="submit" class="btn btn-sm btn-primary">Guardar</button>
                        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
@stop
