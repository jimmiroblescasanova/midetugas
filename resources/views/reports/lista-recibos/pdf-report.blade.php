<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte – Lista de Recibos</title>
    <style type="text/css">
        /**
         * Estilos compatibles con dompdf / CSS 2.1
         * Configuración de página en tamaño carta vertical y márgenes.
         */

        /* Configuración de página específica para dompdf */
        @page {
            size: letter portrait;
            margin: 1.5cm 1.2cm 1.5cm 1.2cm; /* top right bottom left */
        }

        /* Evitamos reset global de márgenes para no confundir la vista de dompdf */
        html, body {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            color: #000000;
            /* Pequeño padding interno para que visualmente se note separación
               incluso si el visor de dompdf no refleja los márgenes de @page */
            padding-left: 5px;
            padding-right: 5px;
        }

        /* Contenedor principal (ajustado a márgenes de página y centrado) */
        .page {
            width: 90%;
            margin: 2rem auto; /* centra el contenido dentro del área útil */
        }

        .full-width-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-table,
        .footer-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-cell,
        .footer-cell {
            vertical-align: middle;
            font-size: 10px;
        }

        .header-title {
            font-size: 13px;
            font-weight: bold;
            text-align: center;
        }

        .header-subtitle {
            font-size: 10px;
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .muted {
            color: #555555;
        }

        .small {
            font-size: 9px;
        }

        .border-top {
            border-top: 1px solid #000000;
        }

        .border-bottom {
            border-bottom: 1px solid #000000;
        }

        .border-left {
            border-left: 1px solid #000000;
        }

        .border-right {
            border-right: 1px solid #000000;
        }

        .table-header {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        .table-bordered {
            border-collapse: collapse;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #000000;
            padding: 2px 3px;
        }

        .spacer-small {
            height: 3px;
        }

        .spacer-medium {
            height: 6px;
        }

        .spacer-large {
            height: 10px;
        }

        .report-meta {
            font-size: 9px;
        }

        .uppercase {
            text-transform: uppercase;
        }

        .nowrap {
            white-space: nowrap;
        }

        /* Filas compactas para que quepa mejor la información */
        .rows-compact tbody tr td {
            padding-top: 1px;
            padding-bottom: 1px;
        }

        /* Configuración de anchos para las 6 columnas principales */
        .col-1,
        .col-2,
        .col-3,
        .col-4,
        .col-5,
        .col-6 {
            width: 16.66%;
        }
    </style>
</head>
<body>
<div class="page">
    <!-- Tabla general para estructurar encabezado, contenido y pie -->
    <table class="full-width-table" cellspacing="0" cellpadding="0">
        <tr>
            <td>
                <!-- ENCABEZADO -->
                <table class="header-table" cellspacing="0" cellpadding="0">
                    <tr>
                        <td class="header-cell text-left" style="width: 33%;">
                            {{-- Área para logo / nombre empresa --}}
                            <div class="small uppercase">
                                {{ config('app.name') }}
                            </div>
                        </td>
                        <td class="header-cell" style="width: 34%;">
                            <div class="header-title uppercase">LISTA DE RECIBOS</div>
                            <div class="header-subtitle muted">Reporte general</div>
                        </td>
                        <td class="header-cell text-right" style="width: 33%;">
                            <!-- Datos de fecha / folio -->
                            <div class="report-meta">
                                Fecha: {{ now()->format('d/m/Y') }}
                            </div>
                        </td>
                    </tr>
                </table>

                <!-- Separador -->
                <div class="spacer-medium"></div>

                <!-- TABLA PRINCIPAL DE 6 COLUMNAS -->
                <table class="table-bordered full-width-table rows-compact" cellspacing="0" cellpadding="0">
                    <thead>
                    <tr class="table-header">
                        @if(!empty($columns) && in_array('folio', $columns))
                            <th class="text-center">Folio</th>
                        @endif

                        @if(!empty($columns) && in_array('cliente', $columns))
                            <th class="text-center">Cliente</th>
                        @endif

                        @if(!empty($columns) && in_array('condominio', $columns))
                            <th class="text-center">Condominio</th>
                        @endif

                        @if(!empty($columns) && in_array('edificio', $columns))
                            <th class="text-center">Edificio</th>
                        @endif

                        @if(!empty($columns) && in_array('departamento', $columns))
                            <th class="text-center">Departamento</th>
                        @endif

                        @if(!empty($columns) && in_array('consumo', $columns))
                            <th class="text-center">Consumo <sup>m3</sup></th>
                        @endif

                        @if(!empty($columns) && in_array('total_mes', $columns))
                            <th class="text-center">Total del mes</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($documents as $document)
                        <tr>
                            @if(!empty($columns) && in_array('folio', $columns))
                                <td>{{ $document->id }}</td>
                            @endif

                            @if(!empty($columns) && in_array('cliente', $columns))
                                <td>{{ $document->client->name }}</td>
                            @endif

                            @if(!empty($columns) && in_array('condominio', $columns))
                                <td>{{ $document->client->project->name }}</td>
                            @endif

                            @if(!empty($columns) && in_array('edificio', $columns))
                                <td>{{ $document->client->line_2 }}</td>
                            @endif

                            @if(!empty($columns) && in_array('departamento', $columns))
                                <td>{{ $document->client->line_3 }}</td>
                            @endif

                            @if(!empty($columns) && in_array('consumo', $columns))
                                <td>{{ $document->month_quantity }}</td>
                            @endif

                            @if(!empty($columns) && in_array('total_mes', $columns))
                                <td>{{ $document->total }}</td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <!-- Separador -->
                <div class="spacer-medium"></div>

                <!-- PIE DE PÁGINA -->
                <table class="footer-table border-top" cellspacing="0" cellpadding="0">
                    <tr>
                        <td class="footer-cell text-left small" style="width: 50%;">
                            {{-- Texto de cortesía o nota legal --}}
                            Este documento es para uso interno y control administrativo.
                        </td>
                        <td class="footer-cell text-right small" style="width: 50%;">
                            {{-- Número de página con dompdf --}}
                            {{-- Página {PAGE_NUM} de {PAGE_COUNT} --}}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
</body>
</html>
