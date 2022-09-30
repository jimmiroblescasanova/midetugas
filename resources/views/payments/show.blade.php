@extends('layouts.main')

@section('header')
    <div class="col-sm-6">
        <h1><i class="fas fa-hand-holding-usd mr-2"></i>Ver pago</h1>
    </div>
    <div class="col-sm-6 d-flex justify-content-end">
        <form action="{{ route('payments.delete', $payment) }}" method="POST">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger btn-block-xs-only">
                <i class="fas fa-trash-alt mr-2"></i>Eliminar</button>
        </form>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">Nombre del cliente</label>
                        <div class="col-sm-9">
                            <input type="text" readonly class="form-control-plaintext" id="name"
                                value="{{ $payment->client->name }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="rfc" class="col-sm-3 col-form-label">R.F.C.</label>
                        <div class="col-sm-9">
                            <input type="text" readonly class="form-control-plaintext" id="rfc"
                                value="{{ $payment->client->rfc }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="total" class="col-form-label">Importe del pago</label>
                            <input type="text" name="total" id="total" class="form-control-plaintext" readonly
                                value="$ {{ number_format($payment->amount, 2) }}">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="total" class="col-form-label">Fecha del pago</label>
                            <input type="text" name="total" id="total" class="form-control-plaintext" readonly
                                value="{{ $payment->date->format('d-m-Y') }}">
                        </div>
                    </div>
                    <hr>
                    <span>Documentos pagados:</span>
                    <table class="table table-sm table-striped table-inverse" id="tablaDocumentos">
                        <thead class="thead-inverse">
                            <tr>
                                <th>Fecha</th>
                                <th>Folio</th>
                                <th>Periodo</th>
                                <th>Abono</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payment->documents as $document)
                                <tr>
                                    <td>{{ $document->date->format('d-m-Y') }}</td>
                                    <td>{{ $document->id }}</td>
                                    <td>{{ $document->period }}</td>
                                    <td>$ {{ number_format($document->pivot->amount, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer d-flex justify-content-end">
                    <button onclick="history.back();" class="btn btn-default btn-sm"><i
                            class="fas fa-hand-point-left mr-2"></i>Atrás</button>
                </div>
            </div>
        </div>
    </div>
@stop
