@extends('layouts.main')

@section('header')
    <div class="col-sm-6">
        <h1><i class="far fa-clipboard"></i> Capturar corte</h1>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="" role="form">
                        <div class="form-group">
                            <label for="client_id">Seleccionar cliente</label>
                            <select class="form-control" name="client_id" id="client_id">
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->account_number }} - {{ $client->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')

@stop
