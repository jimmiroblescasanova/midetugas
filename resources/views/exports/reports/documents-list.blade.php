<table>
    {{-- Encabezado del reporte --}}
    <tr>
        <td colspan="7"><strong>REPORTE: RECIBOS GENERADOS</strong></td>
    </tr>
    <tr>
        <td colspan="7">
            Fecha de generación: {{ $generated_at ?? now()->format('d/m/Y') }}
        </td>
    </tr>
    @isset($project_name)
        <tr>
            <td colspan="7">
                Condominio: {{ $project_name }}
            </td>
        </tr>
    @endisset
    <tr>
        <td colspan="7"></td> {{-- Fila en blanco para separar encabezado de la tabla --}}
    </tr>

    {{-- Tabla de datos --}}
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

        @if(!empty($columns) && in_array('consumo', $columns))
            <th>Consumo (m3)</th>
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
