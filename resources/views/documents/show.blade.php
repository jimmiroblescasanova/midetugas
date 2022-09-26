@extends('layouts.main')

@section('header')
    <div class="col-sm-6">
        <h1><i class="fas fa-tachometer-alt mr-2"></i>Detalles del consumo</h1>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card pt-2">
                <div class="text-center">
                    @if ($document->status === 1 &&
                        auth()->user()->can('authorize_documents'))
                        <a href="{{ route('documents.authorize', $document->id) }}" class="btn btn-app">
                            <i class="far fa-thumbs-up"></i>Autorizar</a>
                    @endif
                    @if ($document->status === 2 &&
                        $document->pending > 0.01 &&
                        auth()->user()->can('pay_documents'))
                        <a href="{{ route('payments.create', $document->client_id) }}" class="btn btn-app">
                            <i class="fas fa-coins"></i>Pagar</a>
                    @endif
                    @if (($document->status == 1 || $document->status == 2) &&
                        auth()->user()->can('cancel_documents'))
                        <a href="{{ route('documents.cancel', $document) }}" class="btn btn-app">
                            <i class="fas fa-ban"></i>Cancelar</a>
                    @endif
                    <a href="{{ route('documents.print', $document->id) }}" class="btn btn-app" target="_blank">
                        <i class="fas fa-print"></i>Imprimir</a>
                    <button type="button" class="btn btn-app" onclick="history.back()">
                        <i class="far fa-hand-point-left"></i>Atrás</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
                            <div class="row">
                                <div class="col-12 col-sm-4">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Saldo Anterior</span>
                                            <span class="info-box-number text-center text-muted mb-0">$
                                                {{ number_format($document->previous_balance, 2) }}<span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Total del mes</span>
                                            <span class="info-box-number text-center text-muted mb-0">$
                                                {{ number_format($document->total, 2) }}<span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">A PAGAR</span>
                                            <span class="info-box-number text-center text-muted mb-0">$
                                                {{ number_format($document->grand_total, 2) }}<span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <h4>Datos del cliente</h4>
                                    <dl>
                                        <dt>No. Cuenta:</dt>
                                        <dd>{{ $document->client->accountNumber }}</dd>
                                        <dt>Nombre:</dt>
                                        <dd>{{ $document->client->name }}</dd>
                                        <dt>Teléfono:</dt>
                                        <dd>{{ $document->client->phone }}</dd>
                                    </dl>
                                </div>
                                <div class="col-6">
                                    <h4>Información del consumo</h4>
                                    <dl>
                                        <dt>Cantidad inicial:</dt>
                                        <dd>{{ $document->start_quantity }} m3</dd>
                                        <dt>Cantidad final:</dt>
                                        <dd>{{ $document->final_quantity }} m3</dd>
                                        <dt>Consumo del mes:</dt>
                                        <dd>{{ $document->month_quantity }} m3</dd>
                                    </dl>
                                </div>
                            </div>
                            <div class="row">
                                <canvas id="myChart" height="120px"></canvas>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
                            <div class="mb-3">
                                Estado del documento: {!! status($document->status) !!}
                            </div>
                            <h3 class="text-primary"><i class="fas fa-image"></i> Fotografía del medidor</h3>
                            <img src="{{ asset('storage/'.$document->photo) }}" class="img-fluid mx-auto d-block rounded"
                                alt="">

                            <div class="text-muted float-sm-right">
                                <p class="text-sm">
                                    Fecha de captura: {{ $document->date->format('d-M-Y') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@stop

@section('scripts')
    <script>
        let ctx = document.getElementById('myChart');
        let myChart = new Chart(ctx, {!! $chart !!});
    </script>
@stop
