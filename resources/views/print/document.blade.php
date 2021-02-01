<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>RECIBO</title>
    <style>
        .container {
            width: 100%;
        }
        /* Estilos para las secciones */
        .headers, .cuerpo, .pie, .pagos {
            vertical-align: top;
        }

        .main-table {
            /*border: 1px solid;
            border-radius: 10px;*/
            margin: 0 auto;
            width: 100%;
        }
        .headers-table {
            border: 2px solid #0956a0;
            border-collapse: collapse;
            border-spacing: 0;
            text-align: center;
            width: 100%;
        }

        .headers-table-title {
            background-color: #0956a0;
            color: white;
        }

        .logo {
            margin-bottom: 30px;
        }

        .cliente .nombre {
            display: block;
        }
        .cliente .domicilio {
            display: block;
        }
        /*    Estilos para el cuerpo */
        .consumo {
            /*border: 2px solid #0956a0;*/
            border-collapse: collapse;
            border-spacing: 0;
        }
        .consumo tr:first-child {
            background-color: #0956a0;
            color: white;
        }
        .consumo tr:nth-child(even) {
            background-color: #d9d9d9;
        }
        .consumo tr td {
            border: 1px solid white;
        }
        .cuerpo-titulo {
            background-color: #0956a0;
            border-radius: 10px;
            color: white;
            margin: 10px auto;
            padding: 3px;
            text-align: center;
            width: 80%;
        }
        .datos-banco tr td:first-child {
            text-align: right;
            width: 50%;
        }
    </style>
</head>
<body>
<div class="container">
    <table class="main-table">
        <tr class="headers">
            <td style="width: 75%;">
                <div class="logo">
                    <img src="{{ asset('logo_new.jpg') }}" alt="Efigas SMART" width="300px">
                </div>
                <div class="cliente">
                    <span class="nombre">{{ $docto->client->name }}</span>
                    <span class="domicilio">{{ $docto->client->full_address }}</span>
                    <span>RFC: {{ $docto->client->rfc }}</span>
                </div>
            </td>
            <td>
                <table class="headers-table">
                    <tr class="headers-table-title"><td>Folio</td></tr>
                    <tr><td>{{ $docto->id }}</td></tr>
                    <tr class="headers-table-title"><td>Total a pagar</td></tr>
                    <tr><td>$ {{ $docto->total }}</td></tr>
                    <tr class="headers-table-title"><td>Periodo</td></tr>
                    <tr><td>{{ $docto->period }}</td></tr>
                    <tr class="headers-table-title"><td>Referencia</td></tr>
                    <tr><td>{{ $docto->reference }}</td></tr>
                    <tr class="headers-table-title"><td>Fecha limite de pago</td></tr>
                    <tr><td>{{ $docto->payment_date->format('d-M-Y') }}</td></tr>
                </table>
            </td>
        </tr>
        <tr class="cuerpo">
            <td>
                <div class="cuerpo-titulo">Detalles del consumo</div>
                <table class="consumo" style="width: 100%;">
                    <tr>
                        <th>Lectura anterior</th>
                        <th>Lectura actual</th>
                        <th>Diferencia</th>
                        <th>Factor de PyT</th>
                        <th>Consumo (m3)</th>
                        <th>Precio por m3</th>
                    </tr>
                    <tr style="text-align: center;">
                        <td>{{ $docto->start_quantity }}</td>
                        <td>{{ $docto->final_quantity }}</td>
                        <td>{{ $docto->month_quantity }}</td>
                        <td>{{ $docto->correction_factor }}</td>
                        <td>{{ number_format($docto->month_quantity * $docto->correction_factor, 2) }}</td>
                        <td>$ {{ number_format($docto->price, 2) }}</td>
                    </tr>
                </table>
            </td>
            <td>
                <div class="cuerpo-titulo">Foto del medidor</div>
                <img src="{{ asset($docto->photo) }}" width="170px" alt="">
            </td>
        </tr>
        <tr class="pie">
            <td style="width: 75%;">
                <div class="cuerpo-titulo">Historial de consumo</div>
                <img src="https://quickchart.io/chart?bkg=white&c={{ $chart }}" height="220px" width="90%" alt="">
            </td>
            <td>
                <div class="cuerpo-titulo">Estado de Cuenta</div>
                <table class="consumo" style="width: 100%">
                    <tr>
                        <th>Concepto</th>
                        <th>Importe</th>
                    </tr>
                    <tr>
                        <td>Saldo anterior</td>
                        <td style="text-align: right;">$ {{ ($docto->client->advance_payment>0.01) ? '-'.number_format($docto->client->advance_payment, 2) : '0.00' }}</td>
                    </tr>
                    <tr>
                        <td>Ajuste meses ant.</td>
                        <td style="text-align: right;">$ {{ number_format($docto->previous_balance, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Subtotal</td>
                        <td style="text-align: right;">$ {{ number_format(($docto->total/1.16), 2) }}</td>
                    </tr>
                    <tr>
                        <td>IVA</td>
                        <td style="text-align: right;"><b>$ {{ number_format($docto->total-($docto->total/1.16), 2) }}</b></td>
                    </tr>
                    <tr>
                        <td>Cargos del mes</td>
                        <td style="text-align: right;">$ {{ number_format($docto->total+$docto->client->balance, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Ajuste mes siguiente</td>
                        <td style="text-align: right;">$ {{ number_format($docto->client->balance, 2) }}</td>
                    </tr>
                    <tr>
                        <td>A pagar</td>
                        <td style="text-align: right;"><b>$ {{ number_format($docto->total, 2) }}</b></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr class="pagos">
            <td style="width: 75%;">
                <div class="cuerpo-titulo">Datos para pago</div>
                <table class="datos-banco" style="width: 100%">
                    <tr>
                        <td>Banco:</td>
                        <td>Santander</td>
                    </tr>
                    <tr>
                        <td>No. Cuenta:</td>
                        <td>65-50840631-7</td>
                    </tr>
<!--                    <tr>
                        <td>No. Tarjeta:</td>
                        <td>1111 2222 3333 4444</td>
                    </tr>-->
                    <tr>
                        <td>Clabe interbancaria:</td>
                        <td>014691655084063172</td>
                    </tr>
                </table>
            </td>
            <td>
                <img src="{{ asset('pagos_aceptados_01.jpg') }}" width="170px" alt="">
            </td>
        </tr>
    </table>
</div>
</body>
</html>
