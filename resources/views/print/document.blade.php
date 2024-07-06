<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>RECIBO</title>
    <style>
        @font-face {
            font-family: 'Montserrat';
            src: url("https://fonts.googleapis.com/css?family=Montserrat") format('truetype');
        }

        body {
            font-family: "Montserrat", sans-serif;
        }

        .container {
            width: 100%;
        }

        .section {
            display: block;
            margin-bottom: 30px;
        }

        .section span {
            display: block;
            text-align: center;
            padding: 2px 0;
        }

        #main-table {
            margin: 0 auto;
            width: 100%;
        }

        #leftColumn {
            vertical-align: top;
        }

        #rightColumn {
            vertical-align: top;
        }

        /* Seccion del logo  */
        #logo {
            text-align: center;
        }

        /* Seccion para los datos de cliente  */
        #client {}

        #client .addressTable {
            font-size: 12px;
            width: 100%;
        }

        #client .addressTable tr td:nth-child(odd) {
            color: gray;
        }

        #client .addressContent {
            font-weight: bold;
        }

        /* Seccion de los datos de consumo del mes  */
        #dataUsage {}

        #dataUsage span {
            background-color: #0CBE32;
            border: 1px solid white;
            color: white;
        }

        /*    Tabla de datos del consumo */
        .consumo {
            /*border: 2px solid #0956a0;*/
            border-collapse: collapse;
            border-spacing: 0;
            font-size: 12px;
        }

        .consumo thead tr:first-child {
            background-color: #0CBE32;
            color: white;
        }

        .consumo tbody tr:nth-child(odd) {
            background-color: #d9d9d9;
        }

        .consumo tbody tr td,
        th {
            border: 1px solid white;
        }

        /* Seccion para la grafica dinamica  */
        .grafica {
            margin-bottom: 30px;
            text-align: center;
        }

        .grafica .title {
            display: block;
        }

        /* Seccion para los datos de pago  */
        #payment {
            border: 2px solid orange;
            font-size: 12px;
            text-align: center;
        }

        #payment .titleOrange {
            background-color: orange;
            color: white;
        }

        .datos-documento {
            font-size: 12px;
            margin-bottom: 30px;
        }

        .headers-table {
            border: 2px solid #0956a0;
            border-collapse: collapse;
            border-spacing: 0;
            text-align: center;
            width: 100%;
        }

        .headers-table tbody tr:nth-child(odd) {
            background-color: #0956a0;
            color: white;
        }

        .headers-table tbody tr td {
            padding: 2px 0;
        }

        .estado-de-cuenta {
            border: 2px solid orange;
            margin-bottom: 30px;
            text-align: center;
        }

        .estado-de-cuenta .title {
            background-color: orange;
            color: white;
            display: block;
        }

        .medidor {
            border: 2px solid #0956a0;
            margin-bottom: 30px;
            text-align: center;
        }

        .medidor .title {
            background-color: #0956a0;
            color: white;
            display: block;
            padding: 2px 0;
        }

        /* Tabla de saldos de la cuenta */
        #tabla-saldos {
            border-spacing: 0;
            font-size: 9px;
            text-align: right;
            width: 100%;
        }

        #tabla-saldos tbody tr:nth-child(odd) {
            background-color: #d9d9d9;
        }

        #tabla-saldos tbody tr td:nth-child(1) {
            text-align: left;
        }

        #tabla-saldos tbody tr td {
            border: 1px solid white;
        }

        #footer {
            background-color: #0956a0;
            border: 3px solid #0956a0;
            border-collapse: collapse;
            border-spacing: 0;
            color: white;
            font-size: 14px;
            text-align: center;
            width: 100%;
        }

        #footer tbody tr td {
            border: 2px solid white;
            padding: 3px 0;
            vertical-align: middle;
        }
    </style>
</head>

<body>
    <div class="container">
        <table id="main-table">
            <tr>
                {{-- primera columna con logo, datos y consumo --}}
                <td id="leftColumn">
                    <div id="logo" class="section">
                        <img src="{{ asset(config('app.logo')) }}" alt="Efigas SMART" width="300px">
                    </div>
                    {{-- consumo mensual --}}
                    <div id="client" class="section">
                        <table class="addressTable">
                            <tbody>
                                <tr>
                                    <td style="width: 15%;">Contrato</td>
                                    <td class="addressContent" style="width: 35%;">
                                        {{ $docto->client->account_number }}
                                    </td>
                                    <td style="width: 15%;">&nbsp;</td>
                                    <td style="width: 35%;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>Cliente</td>
                                    <td>{{ $docto->client->name }}</td>
                                    <td>Colonia</td>
                                    <td>{{ $docto->client->locality }}</td>
                                </tr>
                                <tr>
                                    <td>Calle / Mz / Lt</td>
                                    <td>{{ $docto->client->line_1 }}</td>
                                    <td>Ciudad</td>
                                    <td>{{ $docto->client->city }}</td>
                                </tr>
                                <tr>
                                    <td>Condominio</td>
                                    <td>{{ $docto->client->project->name }}</td>
                                    <td>C.P.</td>
                                    <td>{{ $docto->client->zipcode }}</td>
                                </tr>
                                <tr>
                                    <td>Edificio</td>
                                    <td>{{ $docto->client->line_2 }}</td>
                                    <td>Teléfono</td>
                                    <td>{{ $docto->client->phone }}</td>
                                </tr>
                                <tr>
                                    <td>Departamento</td>
                                    <td>{{ $docto->client->line_3 }}</td>
                                    <td>Email</td>
                                    <td>{{ $docto->client->email }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div id="dataUsage" class="section">
                        <span>CALCULO DEL CONSUMO MENSUAL</span>
                        <table class="consumo" style="width: 100%;">
                            <thead>
                                <tr class="titles">
                                    <th>Lectura anterior</th>
                                    <th>Lectura actual</th>
                                    <th>Diferencia</th>
                                    <th>Factor de PyT</th>
                                    <th>Consumo (m3)</th>
                                    <th>Precio por m3</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="text-align: center;">
                                    <td>{{ $docto->start_quantity }}</td>
                                    <td>{{ $docto->final_quantity }}</td>
                                    <td>{{ $docto->month_quantity }}</td>
                                    <td>{{ $docto->correction_factor }}</td>
                                    <td>{{ number_format(round($docto->month_quantity * $docto->correction_factor, 4), 4) }}</td>
                                    <td>$ {{ number_format($docto->price, 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    {{-- historial del consumo, chart --}}
                    <div class="grafica">
                        <img src="https://quickchart.io/chart?bkg=white&c={{ $chart }}" height="220px"
                            width="75%" alt="historico de consumos">
                    </div>
                    {{-- datos para pago --}}
                    <div id="payment" class="section">
                        <span class="titleOrange">DATOS PARA PAGO</span>
                        <table class="datos-banco" style="width: 100%">
                            <tr>
                                <td><img src="{{ asset('logos/banregio-logo.png') }}" alt="logo banregio" width="100px;"></td>
                                <td><img src="{{ asset('logos/paypal.jpg') }}" alt="logo paypal" width="100px"></td>
                            </tr>
                            <tr>
                                <td>Clabe interbancaria</td>
                                <td>Link de pago</td>
                            </tr>
                            <tr>
                                <td>0585 9700 0058 6066 23</td>
                                <td>https://paypal.me/MIDETUGASSADECV</td>
                                
                            </tr>
                            <tr>
                                <td><img src="{{ asset('logos/logo-bbva.png') }}" alt="logo bbva" width="100px"></td>
                                <td><img src="{{ asset('logos/oxxo.jpg') }}" alt="logo oxxo" width="100px"></td>
                            </tr>
                            <tr>
                                <td>Clabe interbancaria</td>
                                <td>Tarjeta para depósito</td>
                            </tr>
                            <tr>
                                <td>012 691 00121606735 6</td>
                                <td>4347 9848 2127 4353</td>
                            </tr>
                            <tr>
                                <td colspan="2">Pagos a nombre de: MIDETUGAS SA DE CV</td>
                            </tr>
                        </table>
                    </div>
                </td>
                {{-- segunda columna, medidor, resumen de cuenta --}}
                <td id="rightColumn">
                    {{-- datos del docto --}}
                    <div class="datos-documento">
                        <table class="headers-table">
                            <tbody>
                                <tr>
                                    <td>FOLIO</td>
                                </tr>
                                <tr>
                                    <td>{{ $docto->id }}</td>
                                </tr>
                                <tr>
                                    <td>TOTAL A PAGAR</td>
                                </tr>
                                <tr>
                                    <td>{{ contabilidad(($acumulado/100) + $docto->pending - $docto->client->balance) }}</td>
                                </tr>
                                <tr>
                                    <td>PERIODO</td>
                                </tr>
                                <tr>
                                    <td>{{ $docto->period }}</td>
                                </tr>
                                <tr>
                                    <td>REFERENCIA</td>
                                </tr>
                                <tr>
                                    <td>{{ $docto->client->reference }}</td>
                                </tr>
                                <tr>
                                    <td>FECHA LIMITE DE PAGO</td>
                                </tr>
                                <tr>
                                    <td>
                                        @if ($acumulado > 0.01)
                                        INMEDIATO 
                                        @else
                                        {{ $docto->payment_date->format('d-M-Y') }}
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    {{-- estado de cuenta --}}
                    <div class="estado-de-cuenta">
                        <div class="title">Estado de Cuenta</div>
                        <table id="tabla-saldos">
                            <tr>
                                <th>Consumo</th>
                                <td class="text-right">{{ contabilidad($docto->subtotal) }}</td>
                            </tr>
                            <tr>
                                <th>(+)Cargo por admon.</th>
                                <td class="text-right">{{ contabilidad($docto->adm_charge) }}</td>
                            </tr>
                            <tr>
                                <th>(+)Reconexión.</th>
                                <td class="text-right">{{ contabilidad($docto->reconnection) }}</td>
                            </tr>
                            <tr>
                                <th>Subtotal</th>
                                <td class="text-right">
                                    {{ contabilidad($docto->subtotal + $docto->adm_charge + $docto->reconnection) }}</td>
                            </tr>
                            <tr>
                                <th>(-)Descuento</th>
                                <td class="text-right">{{ contabilidad($docto->discount) }}</td>
                            </tr>
                            <tr>
                                <th>(+)IVA</th>
                                <td class="text-right">{{ contabilidad($docto->iva) }}</td>
                            </tr>
                            <tr>
                                <th>Total</th>
                                <td class="text-right">{{ contabilidad($docto->total) }}</td>
                            </tr>
                            <tr>
                                <th>(+)Saldo anterior</th>
                                <td class="text-right">{{ contabilidad($acumulado/100) }}</td>
                            </tr>
                            <tr>
                                <th>(-)Saldo en cuenta</th>
                                <td class="text-right">{{ contabilidad($docto->client->balance) }}</td>
                            </tr>
                            <tr>
                                <th>(=)A PAGAR</th>
                                <td class="text-right">{{ contabilidad(($acumulado/100) + $docto->pending - $docto->client->balance) }}</td>
                            </tr>
                        </table>
                    </div>
                    {{-- medidor --}}
                    <div class="medidor">
                        <div class="title">Medidor</div>
                        <img src="{{ asset('storage/'.$docto->photo) }}" width="170px">
                    </div>
                </td>
            </tr>
            {{-- pie de pagina --}}
            <tr>
                <td colspan="2">
                    <table id="footer">
                        <tbody>
                            <tr>
                                <td>admon@midetugas.com</td>
                                <td>Tel / Whatsapp (+52) 9983 90 5132</td>
                                <td>Emergencias 911</td>
                            </tr>
                            <tr>
                                <td colspan="3">Envíanos una copia del comprobante de pago por Whatsapp o email para
                                    abonar a tu cuenta</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
