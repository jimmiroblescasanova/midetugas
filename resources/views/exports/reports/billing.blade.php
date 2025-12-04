{{-- Encabezado similar al PDF para la exportación a Excel --}}
<table>
    <tr>
        <td colspan="8"><strong>{{ config('app.name') }}</strong></td>
    </tr>
    <tr>
        <td colspan="8">Reporte – Cobranza (Reporte general)</td>
    </tr>
    <tr>
        <td colspan="8">Fecha de generación: {{ now()->format('d/m/Y') }}</td>
    </tr>
</table>

<br>

<table>
    <thead>
    <tr>
        @if(!empty($columns) && in_array('folio', $columns))
            <th>Folio</th>
        @endif

        @if(!empty($columns) && in_array('cliente', $columns))
            <th>Cliente</th>
        @endif

        @if(!empty($columns) && in_array('condominio', $columns))
            <th>Condominio</th>
        @endif

        @if(!empty($columns) && in_array('edificio', $columns))
            <th>Edificio</th>
        @endif

        @if(!empty($columns) && in_array('departamento', $columns))
            <th>Departamento</th>
        @endif

        @if(!empty($columns) && in_array('saldo_anterior', $columns))
            <th>Saldo anterior</th>
        @endif

        @if(!empty($columns) && in_array('saldo_cuenta', $columns))
            <th>Saldo en cuenta</th>
        @endif

        @if(!empty($columns) && in_array('total_mes', $columns))
            <th>Total del mes</th>
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

            @if(!empty($columns) && in_array('saldo_anterior', $columns))
                <td>0</td>
            @endif

            @if(!empty($columns) && in_array('saldo_cuenta', $columns))
                <td>{{ $document->client->balance }}</td>
            @endif

            @if(!empty($columns) && in_array('total_mes', $columns))
                <td>{{ $document->total }}</td>
            @endif
        </tr>
    @endforeach
    </tbody>
</table>
