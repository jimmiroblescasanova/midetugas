@extends('layouts.main')

@section('header')
    <div class="col-sm-6">
        <h1><i class="fas fa-home mr-2"></i>Inicio</h1>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card card-info">
                <div class="card-header">
                    Consumos de gas globales
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="myChart"
                            style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>$ {{ number_format($actual_price, 2) }}</h3>

                    <p>Precio actual m<sup>3</sup></p>
                </div>
                <div class="icon">
                    <i class="fas fa-money-bill-alt"></i>
                </div>
                @can('update_prices')
                    <a href="#" id="newPrice" class="small-box-footer">Actualizar precio <i
                            class="fas fa-arrow-circle-right"></i></a>
                @endcan
            </div>
            <div class="card card-danger">
                <div class="card-header">
                    Clientes atrasados
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm table-striped">
                        <thead>
                            <tr>
                                <th>Folio</th>
                                <th>Cliente</th>
                                <th>Vencimiento</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($documents as $document)
                                <tr>
                                    <td><a href="{{ route('documents.show', $document->id) }}">{{ $document->id }}</a></td>
                                    <td>{{ $document->client->name }}</td>
                                    <td>{{ $document->payment_date->diffForHumans() }}</td>
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
    <div class="modal fade" id="newPriceModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Capturar nuevo precio</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('prices.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-dollar-sign"></i>
                                    </span>
                                </div>
                                <label for="price" class="sr-only">Precio</label>
                                <input type="text" class="form-control" name="price" id="price" autofocus>
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
        let ctx = document.getElementById('myChart').getContext('2d');
        let myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chart['label']) !!},
                datasets: [{
                    label: 'Facturado',
                    data: {!! json_encode($chart['total_amount']) !!},
                    backgroundColor: '#1b7ed4',
                }, {
                    label: 'Pendiente de pago',
                    data: {!! json_encode($chart['total_pending']) !!},
                    backgroundColor: '#a9a9a9',
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

        $('#newPrice').on('click', function(e) {
            e.preventDefault();
            $('#newPriceModal').modal();
        });
    </script>
@stop
