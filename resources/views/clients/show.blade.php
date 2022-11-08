@extends('layouts.main')

@section('title', 'Editar cliente')

@section('header')
    <div class="col-sm-6">
        <h1><i class="fas fa-users mr-2"></i>Información del cliente</h1>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline card-outline-tabs">
                <div class="card-header p-0 border-bottom-0">
                    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill"
                                href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home"
                                aria-selected="true">Datos generales</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill"
                                href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile"
                                aria-selected="false">Información de contactos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-four-messages-tab" data-toggle="pill"
                                href="#custom-tabs-four-messages" role="tab" aria-controls="custom-tabs-four-messages"
                                aria-selected="false">Dirección</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-four-actions-tab" data-toggle="pill"
                                href="#custom-tabs-four-actions" role="tab" aria-controls="custom-tabs-four-actions"
                                aria-selected="false">Acciones</a>
                        </li>
                    </ul>
                </div>
                <form action="{{ route('clients.update', $client) }}" role="form" method="POST">
                @csrf
                @method('patch')
                <div class="card-body">
                    <div class="tab-content" id="custom-tabs-four-tabContent">
                        <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                            @include('clients.forms.general')
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                            @include('clients.forms.contacts')
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-four-messages" role="tabpanel" aria-labelledby="custom-tabs-four-messages-tab">
                            @include('clients.forms.address')
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-four-actions" role="tabpanel" aria-labelledby="custom-tabs-four-actions-tab">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Saldo actual</label>
                                        <input type="text" name="" id="" class="form-control" readonly
                                            value="{{ $client->balance }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Depósito en garantía</label>
                                        <input type="text" name="" id="" class="form-control" readonly
                                            value="{{ number_format($client->deposit, 2) }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    {{-- Free space --}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <a href="{{ route('sms', $client->id) }}" class="btn btn-block btn-success mb-3">
                                        <i class="fas fa-sms mr-2"></i>Enviar SMS prueba</a>
                                </div>
                                <div class="col-md-4">
                                    <a href="{{ route('clients.testEmail', $client->id) }}"
                                        class="btn btn-block btn-primary mb-3">
                                        <i class="fas fa-envelope mr-2"></i>Enviar correo prueba</a>
                                </div>
                                @can('change_status')
                                    <div class="col-md-4">
                                        @if ($client->status == false)
                                            <a href="{{ route('clients.status', $client) }}"
                                                class="btn btn-block btn-warning mb-3  text-white">
                                                <i class="fas fa-user-times mr-2"></i>Suspender</a>
                                        @else
                                            <a href="{{ route('clients.status', $client) }}"
                                                class="btn btn-block btn-warning mb-3  text-white">
                                                <i class="fas fa-user-check mr-2"></i>Activar</a>
                                        @endif
                                    </div>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        @can('edit_clients')
                            <button class="btn btn-sm btn-primary" type="submit">
                                <i class="fas fa-save mr-2"></i>Actualizar cliente
                            </button>
                        @endcan
                        <x-buttons.back route="clients.index" />
                    </div>
                </div>
                </form>
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

@section('scripts')
<script>
    $('#measurer_id').select2({
        theme: 'bootstrap4',
    });

    document.addEventListener("DOMContentLoaded", function(event) {
        let SinMedidor = document.getElementById('SinMedidor');

        if (SinMedidor.checked) {
            $('#measurer_id').prop('disabled', true);
        }

        SinMedidor.addEventListener('click', () => {
            $('#measurer_id').prop('disabled', SinMedidor.checked);
        });
    });
</script>
@stop