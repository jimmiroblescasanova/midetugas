<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<table class="table">
    <thead class="thead-inverse">
    <tr>
        <th>Nombre del cliente</th>
        <th>Departamento</th>
        <th>No. serie medidor</th>
        <th>Lectura anterior</th>
        <th>Lectura actual</th>
        <th>&nbsp;</th>
    </tr>
    </thead>
    <tbody>
    @foreach($clients as $client)
        @if($client->measurer()->exists())
        <tr>
            <td>{{ $client->name }}</td>
            <td>
                @if($client->address()->exists())
                    {{ $client->address->line_2 }}
                @endif
            </td>
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
