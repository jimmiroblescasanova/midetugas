<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Recibo de Deposito en Garantía</title>
    <style>
        * { margin:0; padding:0; }
        p { margin:5px 0 10px 0; }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            max-width: 90%;
            margin: 25px auto;
            /*text-align: center;*/
        }
        span {
            display: block;
        }
        table {
            /*border: gray 1px solid;*/
            width: 100%;
        }
        .title {
            background: #eaeaea;
            text-align: center;
        }
        .title td {
            height: 25px;
        }
        .title-header {
            font-size: 24px;
            text-align: center;
            padding: 15px 0;
        }
        .header {
            padding: 10px 0;
        }
        .total {
            text-align: right;
            font-weight: bold;
        }
        .signature-line {
            padding: 30px 0 0 0;
        }
    </style>
</head>
<body>
<table>
    <tr style="text-align: center;">
        <td><img src="{{ asset('logo_new.png') }}" width="400px" alt=""></td>
    </tr>
    <tr class="title">
        <td class="title-header">Recibo de deposito en garantía</td>
    </tr>
    <tr>
        <td>
            <table>
                <tr>
                    <td class="header" style="width: 25%;">Fecha: {{ $deposit->date->format('d-m-Y') }}</td>
                    <td style="width: 50%;">&nbsp;</td>
                    <td class="total" style="width: 25%;">Total: $ {{ number_format($deposit->total, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <span>Datos fiscales: </span>
                        <span>{{ $deposit->client->name }}</span>
                        <span>{{ $deposit->client->rfc }}</span>
                        <span>
                            {{ $deposit->tax_address }}
                        </span>
                    </td>
                    <td style="text-align: right;">Folio: {{ $deposit->id }}</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table>
                <tr class="title">
                    <td style="width: 70%;">Dirección de servicio</td>
                    <td style="width: 30%;">Tipo de Servicio</td>
                </tr>
                <tr>
                    <td>
                        @if($deposit->client->addess_id != NULL)
                            {{ $deposit->client->address->full_address }}
                        @endif
                    </td>
                    <td>{{ $deposit->type }}</td>
                </tr>
                <tr>
                    <td>
                        <table>
                            <tr class="title">
                                <td style="width: 15%;">Código</td>
                                <td style="width: 15%;">Cantidad</td>
                                <td style="width: 55%;">Descripción</td>
                                <td style="width: 15%;">Importe</td>
                            </tr>
                            <tr>
                                <td>depgar</td>
                                <td>1</td>
                                <td>Depósito en garantía</td>
                                <td style="text-align:right;">$ {{ number_format($deposit->total, 2) }}</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td class="total">Total:</td>
                                <td class="total">$ {{ number_format($deposit->total, 2) }}</td>
                            </tr>
                        </table>
                    </td>
                    <td>&nbsp;</td>
                </tr>
                <tr class="title">
                    <td>Importe con letra</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>{{ $letras }}</td>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr class="title">
        <td>
            Firmas de conformidad
        </td>
    </tr>
    <tr>
        <td>
            <table>
                <tr style="text-align: center;">
                    <td>
                        <span>Administración</span>
                        <span class="signature-line">__________________________</span>
                        <span>Nombre y Firma</span>
                    </td>
                    <td>
                        <span>Cliente</span>
                        <span class="signature-line">__________________________</span>
                        <span>Nombre y Firma</span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr class="title">
        <td>Información bancaria</td>
    </tr>
    <tr>
        <td style="font-size: 14px;">
            <span>Banco: Santander</span>
            <span>No. Cuenta: 65-50840631-7</span>
            <span>CLABE: 014691655084063172</span>
            <span>Nombre: JOMAX OBRA Y EQUIPO INDUSTRIAL SA DE CV</span>
        </td>
    </tr>
</table>
</body>
</html>
