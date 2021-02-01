<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        * { margin:0; padding:0; }
        p { margin:5px 0 10px 0; }
        body {
            margin: 20px auto;
            width: 90%;
        }
        .img-header {
            padding: 15px 0;
            text-align: center;
        }
        .report-header {
            font-size: 24px;
            padding: 20px 0;
            text-align: center;
            text-transform: uppercase;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        .table-bordered td, th {
            border: 1px solid gray;
            padding: 5px 0;
            text-align: center;
        }
    </style>
</head>
<body>
<table style="margin-bottom: 25px;">
    <tr>
        <td colspan="2" class="img-header"><img src="{{ asset('logo_new.png') }}" height="60px"></td>
    </tr>
    <tr>
        <td colspan="2" class="report-header">Reporte de toma de lecturas</td>
    </tr>
    <tr>
        <td>Condominio: {{ $project->name }}</td>
        <td style="text-align: right;">Fecha de impresión: {{ NOW()->format('d-m-Y') }}</td>
    </tr>
</table>
<table class="table-bordered">
    <thead>
    <tr>
        <th>Nombre del cliente</th>
        <th>Departamento</th>
        <th>No. serie medidor</th>
        <th>Lectura anterior</th>
        <th>Lectura actual</th>
        <th>Correcto</th>
    </tr>
    </thead>
    <tbody>
    @foreach($clients as $client)
        @if($client->measurer()->exists())
        <tr>
            <td>{{ $client->name }}</td>
            <td>{{ $client->line_2 }}</td>
            <td>{{ $client->measurer->serial_number }}</td>
            <td>{{ $client->measurer->actual_measure }}</td>
            <td>_____________</td>
            <td></td>
        </tr>
        @endif
    @endforeach
    </tbody>
</table>
</body>
</html>
