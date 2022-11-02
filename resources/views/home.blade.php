@extends('layouts.main')

@section('title', 'Dashboard')

@section('header')
    <div class="col-sm-6">
        <h1><i class="fas fa-home mr-2"></i>Inicio</h1>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-9">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    Capacidad de los condominios
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="myChart"
                            style="min-height: 300px; height: 300px; max-height: 500px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>$ {{ number_format($actual_price, 2) }}</h3>

                    <p>Precio actual m<sup>3</sup></p>
                </div>
                <div class="icon">
                    <i class="fas fa-gas-pump"></i>
                </div>
                @can('update_prices')
                    <a href="#" id="newPrice" class="small-box-footer">Actualizar precio <i
                            class="fas fa-arrow-circle-right"></i></a>
                @endcan
            </div>
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>$ {{ number_format($today_payments, 2) }}</h3>

                    <p>Ingresos del día</p>
                </div>
                <div class="icon">
                    <i class="fas fa-hand-holding-usd"></i>
                </div>
                <a href="{{ route('payments.index') }}" class="small-box-footer">
                    Ver todos los pagos <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $pending_doctos }}</h3>

                    <p>Documentos sin autorizar</p>
                </div>
                <div class="icon">
                    <i class="fas fa-receipt"></i>
                </div>
                <a href="{{ route('documents.index', 'status=1') }}" class="small-box-footer">
                    Ver documentos pendientes <i class="fas fa-arrow-circle-right"></i>
                </a>
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
                    label: 'Capacidad actual',
                    data: {!! json_encode($chart['actual_capacity']) !!},
                    backgroundColor: '#C0392B',
                }, {
                    label: 'Capacidad total',
                    data: {!! json_encode($chart['total_capacity']) !!},
                    backgroundColor: '#1b7ed4',
                }]
            },
            options: {
                scales: {
                    xAxes: [{
                        stacked: true,
                    }],
                    yAxes: [{
                        stacked: true,
                        ticks: {
                            beginAtZero: true,
                            stepSize: 1000,
                        }
                    }],
                }
            }
        });

        $('#newPrice').on('click', function(e) {
            e.preventDefault();
            $('#newPriceModal').modal();
        });
    </script>
@stop
