@extends('layouts.main')

@section('header')
    <div class="col-sm-6">
        <h1><i class="far fa-clipboard"></i> Capturar corte</h1>
    </div>
@stop

@section('alert')
    @include('partials.alerts.success')
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('documents.store') }}" method="post" role="form" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="client_id">Seleccionar cliente</label>
                                    <select class="form-control" name="client_id" id="client_id">
                                        @foreach ($clients as $client)
                                            <option value="{{ $client->id }}">{{ $client->account_number }} - {{ $client->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="date">Fecha</label>
                                    <input type="date" name="date" id="date" class="form-control">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="final_quantity">Lectura actual</label>
                                    <input type="text" name="final_quantity" id="final_quantity" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <label class="btn btn-app" for="my-file-selector">
                                    <input type="file"
                                           id="my-file-selector"
                                           class="d-none"
                                           name="photo"
                                           onchange="$('#upload-file-info').html(this.files[0].name)"
                                           accept="image/*" capture>
                                    <i class="fas fa-camera"></i> Tomar foto
                                </label>
                                <span class='label label-info' id="upload-file-info"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')

@stop
