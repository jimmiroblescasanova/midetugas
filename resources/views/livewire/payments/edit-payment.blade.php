<div>
    <div class="row">
        <div class="col-4">
            <div class="info-box">
                <span class="info-box-icon bg-success"><i class="fas fa-dollar-sign"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Importe total</span>
                    <span class="info-box-number">$ {{ $payAmount }}</span>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fas fa-file-invoice-dollar"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Importe abonado</span>
                    <span class="info-box-number">$ {{ $totalPaid }}</span>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="info-box">
                <span class="info-box-icon bg-warning"><i class="fas fa-hand-holding-usd"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Pendiente por abonar</span>
                    <span class="info-box-number">$ {{ $pendingPaid }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    Datos generales
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="date">Fecha</label>
                        <input type="text" class="form-control" readonly value="{{ $payment->date->format('d/m/Y') }}">
                    </div>
                    <div class="form-group">
                      <label for="client">Cliente:</label>
                      <input type="text" class="form-control" readonly name="client" id="client" value="{{ $payment->client->name }}">
                    </div>
                    <div class="form-group">
                      <label for="client">Saldo actual:</label>
                      <input type="text" class="form-control" readonly name="client" id="client" value="{{ number_format($payment->client->balance, 2) }}">
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" wire:model="usingBalance">
                            Usar saldo en cuenta
                          </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <span class="">Doctos pagados</span>
                        <button type="button" class="btn btn-xs btn-primary"  data-toggle="modal" data-target="#new_pay">Pagar un recibo</button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Folio</th>
                                <th>Fecha</th>
                                <th>Abono</th>
                                <th class="text-center"><i class="fas fa-trash-alt"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pays as $pay)
                            <tr>
                                <td scope="row">{{ $pay->id }}</td>
                                <td>{{ $pay->date->format('d/m/Y') }}</td>
                                <td class="text-right">$ {{ number_format($pay->pivot->amount, 2) }}</td>
                                <td class="text-center">
                                    <button type="button" wire:click="deletePay({{ $pay->id }})" class="btn btn-xs btn-danger">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="new_pay" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Seleccionar documento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Fecha</th>
                                <th>Saldo</th>
                                <th>Abono</th>
                                <th>Aplicar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($documents as $document)
                            <tr id="{{ $document->id }}">
                                <td>{{ $document->id }}</td>
                                <td>{{ $document->date->format('d/m/Y') }}</td>
                                <td>{{ number_format($document->pending, 2) }}</td>
                                <td><input type="number" onchange="setCurrency(this);" class="form-control form-control-sm" name="pay-{{ $document->id }}"></td>
                                <td>
                                    <button type="button" onclick="addPay({{ $document->id }})" class="btn btn-sm  btn-success">Aplicar</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    const closePayment = document.getElementById('closePayment');

    closePayment.addEventListener('click', function(e) {
        e.preventDefault();
        if (confirm("¿Estas seguro?, El saldo pendiente se agregará a la cuenta del cliente.")) {
            Livewire.emit('emitClosePayment');
        }
    });

    function addPay(id) {
        let amount = $(document).find('input[name="pay-'+id+'"]').val();
        console.log(amount);
        Livewire.emit('emitPay', id, amount);
    }

    Livewire.on('closeModal', () => {
        $('#new_pay').modal('hide');
    });
</script>
@endsection