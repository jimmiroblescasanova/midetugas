<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        p {
            margin: 5px 0 10px 0;
        }

        body {
            margin: 20px auto;
            width: 90%;
        }

        .img-header {
            padding: 15px 0;
            text-align: center;
            width: 300px;
        }

        .report-header {
            font-size: 24px;
            padding: 10px 0;
            text-align: center;
            text-transform: uppercase;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        table.table-bordered {
            font-size: 10px;
        }

        .table-bordered td,
        th {
            border: 1px solid gray;
            padding: 5px 0;
            text-align: center;
        }

        .table-bordered td.numeric-cell {
            width: auto;
            padding: 0 3px;
        }
    </style>
</head>

<body>
    <table style="margin-bottom: 25px;">
        <tr>
            <td colspan="2" style="text-align: right;">{{ NOW()->format('d-m-Y') }}</td>
        </tr>
        <tr>
            <td class="img-header"><img src="{{ asset(config('app.logo')) }}" width="200px"></td>
            <td class="report-header">Reporte de saldos de cliente</td>
        </tr>
    </table>
    <table class="table-bordered">
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Condominio</th>
                <th>Torre</th>
                <th>Departamento</th>
                <th>Cargos</th>
                <th>Abonos</th>
                <th>Saldo</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($documents as $document)
            <tr>
                <td>{{ $document->client->name }}</td>
                <td>{{ $document->client->project->name }}</td>
                <td>{{ $document->client->line_2 }}</td>
                <td>{{ $document->client->line_3 }}</td>
                <td class="numeric-cell">{{ contabilidad($document->suma /100) }}</td>
                <td class="numeric-cell">{{ contabilidad(($document->suma - $document->pendiente) / 100) }}</td>
                <td class="numeric-cell">{{ contabilidad($document->pendiente / 100) }}</td>
            </tr>
            @empty
                <tr>
                    <td colspan="7">No hay información en el rango seleccionado.</td>
                </tr>
            @endforelse 
        </tbody>
    </table>
</body>

</html>
