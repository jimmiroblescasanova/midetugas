@extends('layouts.main')

@section('header')
    <div class="col-sm-6">
        <h1><i class="fas fa-tachometer-alt"></i> Detalles del consumo</h1>
    </div>
@stop

@section('content')
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
                                            <span class="info-box-text text-center text-muted">Consumo total</span>
                                            <span class="info-box-number text-center text-muted mb-0">{{ $document->final_quantity }} m3</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Consumo del mes</span>
                                            <span class="info-box-number text-center text-muted mb-0">{{ $document->month_quantity }} m3</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">TOTAL</span>
                                            <span class="info-box-number text-center text-muted mb-0">$ {{ $document->total }}<span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <h4>Datos del cliente</h4>
                                    <dl>
                                        <dt>Nombre:</dt>
                                        <dd>{{ $document->client->name }}</dd>
                                        <dt>RFC:</dt>
                                        <dd>{{ $document->client->rfc }}</dd>
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
                            <h3 class="text-primary"><i class="fas fa-image"></i> Fotografía del medidor</h3>
                            <img src="{{ asset($document->photo) }}" class="img-fluid mx-auto d-block rounded" alt="">

                            <div class="text-muted float-sm-right">
                                <p class="text-sm">
                                    Fecha de captura: {{ $document->date->format('d-M-Y') }}
                                </p>
                            </div>

                            <div class="text-center mt-5 mb-3">
                                @if ( ($document->status === 1) && ( auth()->user()->can('authorize_documents') ) )
                                    <a href="{{ route('documents.authorize', $document->id) }}" class="btn btn-app">
                                        <i class="far fa-thumbs-up"></i>Autorizar</a>
                                @endif
                                @if ( ($document->status === 2) && ($document->pending > 0.01) && (auth()->user()->can('pay_documents')) )
                                    <button type="button" class="btn btn-app" id="pay">
                                        <i class="fas fa-coins"></i>Pagar</button>
                                @endif
                                @if ( ($document->status != 3) && (auth()->user()->can('cancel_documents')) )
                                    <a href="{{ route('documents.cancel', $document->id) }}" class="btn btn-app">
                                        <i class="fas fa-ban"></i>Cancelar</a>
                                @endif
                                    <a href="" class="btn btn-app">Link to Comercial(r)</a>
                                    <a href="{{ route('documents.print', $document->id) }}" class="btn btn-app" target="_blank"><i class="fas fa-print"></i> Imprimir</a>
                                    <button type="button" class="btn btn-app" onclick="history.back()">
                                        <i class="far fa-hand-point-left"></i>Atrás</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@stop

@section('modal-section')
    <div class="modal fade" id="paymentModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Capturar pago</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('payments.store', '#pay') }}" method="POST">
                    @csrf
                    <input type="hidden" name="document_id" value="{{ $document->id }}">
                    <input type="hidden" name="client_id" value="{{ $document->client_id }}">
                    <div class="modal-body">
                        @include('partials.alerts.danger')
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" name="advancePaymentCheck" id="advancePaymentCheck">
                                    <label class="form-check-label" for="advancePaymentCheck">
                                        Usar saldo anterior: $<b>{{ number_format($advance_payment, 2) }}</b> <small>(Por pagar: ${{ $document->pending - $advance_payment }})</small>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="date">Fecha</label>
                                    <input type="date"
                                           class="form-control {{ $errors->first('date') ? 'is-invalid' : '' }}"
                                           name="date"
                                           id="date" placeholder="dd/mm/yyyy">
                                    {!! $errors->first('date', '<div class="invalid-feedback">:message</div>') !!}
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="amount">Importe pagado</label>
                                    <input type="text" class="form-control {{ $errors->first('amount') ? 'is-invalid' : '' }}" name="amount" id="amount">
                                    {!! $errors->first('amount', '<div class="invalid-feedback">:message</div>') !!}
                                </div>
                            </div>
                        </div>
                        <small>El excedente será agregado a la cuenta del cliente.</small>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Pagar</button>
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
        if(window.location.hash === '#pay')
        {
            $('#paymentModal').modal('show');
        }

        let ctx = document.getElementById('myChart');
        let myChart = new Chart(ctx, {
            type: "bar",
            data: {
                datasets: [{
                    label: 'Últimos consumos',
                    backgroundColor: 'rgb(128,128,128, 0.5)',
                    borderColor: 'rgb(128,128,128)',
                    data: [
                        @foreach($historic as $h)
                            "{{ $h->month_quantity }}",
                        @endforeach
                    ],
                }],
                labels: [
                    @foreach($historic as $h)
                        "{{ $h->period }}",
                    @endforeach
                ]
            },
            options: {
                responsive: true,
                scales: {
                    yAxes: [{
                        ticks: {
                            suggestedMin: 50,
                            suggestedMax: 100
                        }
                    }]
                }
            }
        });

        $('#pay').on('click', function (e) {
            e.preventDefault();
            $('#paymentModal').modal();
        });

        $('#paymentModal').on('hide.bs.modal', function(){
            window.location.hash = '#';
        });
    </script>
@stop
