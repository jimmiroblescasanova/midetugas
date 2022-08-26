@extends('layouts.main')

@section('header')
    <div class="col-sm-6">
        <h1><i class="fas fa-hand-holding-usd"></i> Crear un pago</h1>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('payments.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="client" value="{{ $client->id }}">
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">Nombre del cliente</label>
                            <div class="col-sm-9">
                                <input type="text" readonly class="form-control-plaintext" id="name"
                                    value="{{ $client->name }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="rfc" class="col-sm-3 col-form-label">R.F.C.</label>
                            <div class="col-sm-9">
                                <input type="text" readonly class="form-control-plaintext" id="rfc"
                                    value="{{ $client->rfc }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="total" class="col-sm-3 col-form-label">Importe del pago</label>
                            <div class="col-sm-3">
                                <input type="number" step=".01" name="total" id="total" class="form-control"
                                    value="0">
                            </div>
                            <label for="pending" class="col-sm-3 col-form-label">Pendiente por abonar</label>
                            <div class="col-sm-3">
                                <input type="text" id="pending" class="form-control-plaintext">
                            </div>
                        </div>
                        <hr>
                        <table class="table table-sm table-striped table-inverse">
                            <thead class="thead-inverse">
                                <tr>
                                    <th>Fecha</th>
                                    <th>Folio</th>
                                    <th>Periodo</th>
                                    <th>Total</th>
                                    <th>Pendiente</th>
                                    <th>Abono</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($client->documents as $i => $document)
                                    <tr>
                                        <td scope="row">{{ $document->date->format('d/m/Y') }}</td>
                                        <td>{{ $document->id }}</td>
                                        <td>{{ $document->period }}</td>
                                        <td>{{ $document->total }}</td>
                                        <td>{{ $document->pending }}</td>
                                        <td style="width:15%;"><input class="form-control form-control-sm" type="number"
                                                step=".01" name="pay[]" id="pay-{{ $i }}"></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="form-group">
                            <button type="submit" class="btn btn-sm btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script></script>
@stop
