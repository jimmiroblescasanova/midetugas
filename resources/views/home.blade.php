@extends('layouts.main')

@section('header')
    <div class="col-sm-6">
        <h1><i class="fas fa-home"></i> Inicio</h1>
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
                        <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-danger">
                <div class="card-header">
                    Clientes atrasados
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm table-striped">
                        <tr>
                            <th>Cliente</th>
                            <th>Recibo</th>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script>
        var areaChartData = {
            labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            datasets: [
                {
                    label               : 'Gas m3',
                    backgroundColor     : 'rgba(60,141,188,0.9)',
                    borderColor         : 'rgba(60,141,188,0.8)',
                    pointRadius          : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(60,141,188,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data                : [28, 48, 40, 19, 86, 27, 90]
                },
            ]
        };
        //-------------
        //- BAR CHART -
        //-------------
        var barChartCanvas = $('#barChart').get(0).getContext('2d');

        var barChartOptions = {
            responsive              : true,
            maintainAspectRatio     : false,
            datasetFill             : false
        };

        var barChart = new Chart(barChartCanvas, {
            type: 'bar',
            data: areaChartData,
            options: barChartOptions
        });


    </script>
@stop
