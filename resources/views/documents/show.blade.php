@extends('layouts.main')

@section('title', 'Ver / Editar recibo')

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
                            <i class="far fa-thumbs-up"></i>Autorizar
                        </a>
                    @endif
                    <a href="{{ route('documents.print', $document->id) }}" class="btn btn-app" target="_blank">
                        <i class="fas fa-print"></i>Imprimir</a>
                    @if ($document->status === 2)
                        <a href="{{ route('documents.sendEmail', $document) }}" class="btn btn-app">
                            <i class="fas fa-envelope"></i>Email
                        </a>
                    @endif
                    @if ($document->status == 1)
                        <button class="btn btn-app" data-toggle="modal" data-target="#discountModal">
                            <i class="fas fa-percent"></i>Descuento
                        </button>
                    @endif
                    @if (($document->status == 1 || $document->status == 2) &&
                        auth()->user()->can('cancel_documents'))
                        <a href="{{ route('documents.cancel', $document) }}" class="btn btn-app">
                            <i class="fas fa-ban"></i>Cancelar</a>
                    @endif
                    <a href="{{ route('documents.index') }}" class="btn btn-app">
                        <i class="far fa-hand-point-left"></i>Atrás
                    </a>
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
                                        <dt>Consumo <sup>m3</sup> del mes:</dt>
                                        <dd>{{ number_format(round($document->month_quantity * $document->correction_factor, 2), 2) }} m3</dd>
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
                            <table class="table table-sm">
                                <tr>
                                    <th>Consumo</th>
                                    <td class="text-right">{{ number_format($document->subtotal, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>(+)Cargo por admon.</th>
                                    <td class="text-right">{{ number_format($document->adm_charge, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>(+)Reconexión</th>
                                    <td class="text-right">{{ number_format($document->reconnection, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Subtotal</th>
                                    <td class="text-right">
                                        {{ number_format($document->subtotal + $document->adm_charge + $document->reconnection, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>(-)Descuento</th>
                                    <td class="text-right">{{ number_format($document->discount, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>(+)IVA</th>
                                    <td class="text-right">{{ number_format($document->iva, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Total</th>
                                    <td class="text-right">{{ number_format($document->total, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>(+)Saldo anterior</th>
                                    <td class="text-right">{{ number_format($acumulado/100, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>(-)Saldo en cuenta</th>
                                    <td class="text-right">{{ number_format($document->client->balance, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>(=)A PAGAR</th>
                                    <td class="text-right">{{ contabilidad(($acumulado/100) + $document->pending - $document->client->balance) }}</td>
                                </tr>
                            </table>
                            <h3 class="text-primary"><i class="fas fa-image"></i> Fotografía del medidor</h3>
                            <img src="{{ asset('storage/' . $document->photo) }}" height="300px"
                                class="mx-auto d-block rounded" alt="">

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
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    Relación de pagos
                </div>
                <div class="card-body p-0">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Fecha</th>
                                <th>Importe $</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($document->payments as $payment)
                            <tr>
                                <td scope="row">
                                    <a href="{{ route('payments.show', $payment) }}">{{ $payment->id }}</a>
                                </td>
                                <td>{{ $payment->date->format('d/m/Y') }}</td>
                                <td>$ {{ number_format($payment->amount, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('modal-section')
    <div class="modal fade" id="discountModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Aplicar descuento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('documents.discount', $document) }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                          <label for="discount">Cantidad del descuento</label>
                          <input type="text" class="form-control" name="discount" id="discount">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let ctx = document.getElementById('myChart');
        let myChart = new Chart(ctx, {!! $chart !!});
    </script>
@stop
