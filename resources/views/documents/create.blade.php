@extends('layouts.main')

@section('header')
    <div class="col-sm-6">
        <h1><i class="far fa-clipboard mr-2"></i>Capturar corte</h1>
    </div>
@stop

@section('alert')
    @include('partials.alerts.warning')
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('documents.store') }}" method="post" role="form" enctype="multipart/form-data"
                        autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="client_id">Seleccionar cliente
                                        <i class="fas fa-question-circle fa-xs" data-toggle="tooltip" data-placement="right" title="Solo muestran clientes en condominios con inventario y medidor asociado."></i>
                                    </label>
                                    <select class="form-control select2bs4" name="client_id" id="client_id">
                                        @foreach ($clients as $client)
                                            @if ($client->measurer()->exists())
                                                <option value="{{ $client->id }}">{{ $client->name }} - Edif: {{ $client->line_2 }} - Depto: {{ $client->line_3 }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-12">
                                <x-form-input type="date" name="date" label="Fecha de corte:">
                                    @slot('prepend')
                                    <i class="fas fa-calendar-alt"></i>
                                    @endslot
                                </x-form-input>
                            </div>
                            <div class="col-md-4 col-12">
                                <x-form-input name="final_quantity" label="Lectura actual:">
                                    @slot('prepend')
                                    <i class="fas fa-barcode"></i>
                                    @endslot
                                </x-form-input>
                            </div>
                            <div class="col-md-4 col-12">
                                <x-form-input name="admCharge" label="Cargo por administración:">
                                    @slot('prepend')
                                    <i class="fas fa-dollar-sign"></i>
                                    @endslot
                                </x-form-input>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <label class="btn btn-app" for="my-file-selector">
                                    <input type="file" id="my-file-selector" class="d-none" name="photo"
                                        onchange="$('#upload-file-info').html(this.files[0].name)" accept="image/*" capture>
                                    <i class="fas fa-camera"></i> Tomar foto
                                </label>
                                <span class='label label-info {{ $errors->first('photo') ? 'is-invalid' : '' }}'
                                    id="upload-file-info"></span>
                                {!! $errors->first('photo', '<div class="invalid-feedback">:message</div>') !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block-xs-only">
                                <i class="fas fa-save mr-2"></i>Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script>
        $('[data-toggle="tooltip"]').tooltip();
    </script>
@stop
