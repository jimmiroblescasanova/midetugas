<table>
    <thead>
    <tr>
        <td>Fecha</td>
        <td>Folio</td>
        <td>Cliente</td>
        <td>Total</td>
        <td>Pendiente</td>
    </tr>
    </thead>
    <tbody>
    @foreach($documents as $document)
        <tr>
            <td>{{ $document->date->format('d-m-Y') }}</td>
            <td>{{ $document->id }}</td>
            <td>{{ $document->client->name }}</td>
            <td>{{ $document->total }}</td>
            <td>{{ $document->pending }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
