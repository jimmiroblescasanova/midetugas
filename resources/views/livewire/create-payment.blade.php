<div>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-hand-holding-usd"></i> Crear un pago</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('payments.store') }}" onsubmit="return validateForm()"
                                method="POST">
                                @csrf
                                <input type="hidden" name="client" value="{{ $client->id }}">
                                <div class="form-group row">
                                    <label for="name" class="col-sm-3 col-form-label">Nombre del cliente</label>
                                    <div class="col-sm-9">
                                        <input type="text" readonly class="form-control-plaintext" id="name"
                                            value="{{ $client->name }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="rfc" class="col-sm-3 col-form-label">R.F.C.</label>
                                    <div class="col-sm-9">
                                        <input type="text" readonly class="form-control-plaintext" id="rfc"
                                            value="{{ $client->rfc }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="total" class="col-sm-3 col-form-label">Importe del pago</label>
                                    <div class="col-sm-3">
                                        <input type="number" step=".01" wire:model="total" name="total"
                                            id="total" class="form-control">
                                    </div>
                                    <label for="pending" class="col-sm-3 col-form-label">Pendiente por abonar</label>
                                    <div class="col-sm-3">
                                        <input type="text" readonly id="pending" name="pending"
                                            class="form-control-plaintext" value="{{ $total - $paymentSum }}">
                                    </div>
                                </div>
                                <hr>
                                <table class="table table-sm table-striped table-inverse" id="tablaDocumentos">
                                    <thead class="thead-inverse">
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Folio</th>
                                            <th>Periodo</th>
                                            <th>Total</th>
                                            <th>Pendiente</th>
                                            <th>Abono</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($client->documents as $i => $document)
                                            <tr>
                                                <td scope="row">{{ $document->date->format('d/m/Y') }}</td>
                                                <td>{{ $document->id }}</td>
                                                <td>{{ $document->period }}</td>
                                                <td>{{ $document->total }}</td>
                                                <td id="row-{{ $i }}">{{ $document->pending }}</td>
                                                <td style="width:15%;">
                                                    <input class="form-control form-control-sm" type="number"
                                                        name="pay[{{ $document->id }}]" step=".01"
                                                        wire:model="pay.{{ $i }}"
                                                        id="pay-{{ $i }}">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-sm btn-primary">Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        var tabla = document.getElementById("tablaDocumentos");

        function validateForm() {
            var pending = document.getElementById("pending").value;

            for (let i = 1, row; row = tabla.rows[i]; i++) {
                var saldoDocumento = row.cells[4].innerText;
                var abonoDocumento = document.getElementById("pay-" + (i - 1)).value;

                if (abonoDocumento > saldoDocumento) {
                    alert("El abono no puede ser mayor que el saldo pendiente");
                    return false;
                }
            }

            if (pending < 0) {
                alert("El pendiente por abonar no puede ser negativo");
                return false;
            }

            if (pending > 0) {
                if (!confirm("El saldo pendiente será agregado a la cuenta")) {
                    return false;
                }
            }
        }
    </script>
</div>
