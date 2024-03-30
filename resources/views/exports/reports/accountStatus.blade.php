<table>
    <thead>
    <tr>
        <td>Cliente</td>
        <td>Nombre Corto</td>
        <td>Condominio</td>
        <td>Torre</td>
        <td>Departamento</td>
        <td>Cargos</td>
        <td>Abonos</td>
        <td>Saldo</td>
    </tr>
    </thead>
    <tbody>
    @foreach($documents as $document)
        <tr>
            <td>{{ $document->client->name }}</td>
            <td>{{ $document->client->shortName }}</td>
            <td>{{ $document->client->project->name }}</td>
            <td>{{ $document->client->line_2 }}</td>
            <td>{{ $document->client->line_3 }}</td>
            <td>{{ contabilidad($document->suma /100) }}</td>
            <td>{{ contabilidad(($document->suma - $document->pendiente) / 100) }}</td>
            <td>{{ contabilidad($document->pendiente / 100) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
