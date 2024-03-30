<table class="table">
    <thead>
        <tr>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td scope="row"></td>
            <td>ESTADO DE CUENTA</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>{{ NOW()->format('d/m/Y') }}</td>
        </tr>
        <tr></tr>
    </tbody>
</table>

@foreach ($clients as $client)
    {{ $saldo_total = 0 }}
    <table class="table">
        <thead>
            <tr>
                <th>id</th>
                <th>{{ $client->id }}</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td scope="row">rfc</td>
                <td>{{ $client->rfc }}</td>
            </tr>
            <tr>
                <td scope="row">nombre</td>
                <td>{{ $client->name }}</td>
            </tr>
        </tbody>
    </table>

    <table class="table">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Folio</th>
                <th>Mes</th>
                <th>Cargo</th>
                <th>Abono</th>
                <th>Saldo</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($client->documents as $document)
                {{ $saldo_total = $saldo_total + $document->pending }}
                <tr>
                    <td>{{ $document->date->format('d/m/Y') }}</td>
                    <td>{{ $document->id }}</td>
                    <td>{{ $document->period }}</td>
                    <td>{{ $document->total }}</td>
                    <td>-{{ $document->total - $document->pending }}</td>
                    <td>{{ $saldo_total }}</td>
                </tr>
            @endforeach
            <tr></tr>
            <tr>
                <td></td>
                <td>Resumen</td>
            </tr>
            <tr>
                <td></td>
                <td>Total de Cargos</td>
                <td></td>
                <td>{{ $client->documents->sum('total') }}</td>
            </tr>
            <tr>
                <td></td>
                <td>Total de Abonos</td>
                <td></td>
                <td>-{{ $client->documents->sum('total') - $client->documents->sum('pending') }}</td>
            </tr>
            <tr>
                <td></td>
                <td>Saldo Final</td>
                <td></td>
                <td>{{ $client->documents->sum('pending') }}</td>
            </tr>
            <tr></tr>
            <tr></tr>
        </tbody>
    </table>
@endforeach
