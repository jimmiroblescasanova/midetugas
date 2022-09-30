<div>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-hand-holding-usd"></i> Reportes: Depósitos en Garantía</h1>
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
                            <div class="row">
                                <div class="form-group col-sm-2">
                                    <label for="year">Año</label>
                                    <select wire:model.defer="year" id="year" class="form-control">
                                        <option value="all">-- Todos --</option>
                                        <option value="2022">2022</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-3">
                                    <label for="month">Mes</label>
                                    <select wire:model.defer="month" id="month" class="form-control">
                                        <option value="all">-- Todos los meses --</option>
                                        <option value="01">Enero</option>
                                        <option value="02">Febrero</option>
                                        <option value="03">Marzo</option>
                                        <option value="04">Abril</option>
                                        <option value="05">Mayo</option>
                                        <option value="06">Junio</option>
                                        <option value="07">Julio</option>
                                        <option value="08">Agosto</option>
                                        <option value="09">Septiembre</option>
                                        <option value="10">Octubre</option>
                                        <option value="11">Noviembre</option>
                                        <option value="12">Diciembre</option>
                                    </select>
                                </div>
                                <div wire:ignore class="form-group col-sm-5">
                                    <label for="client">Cliente</label>
                                    <select name="client" id="client" class="form-control select2bs4">
                                        <option value="all">-- Todos los clientes --</option>
                                        @foreach ($allClients as $client)
                                            <option value="{{ $client->id }}">{{ $client->name }}
                                                ({{ $client->line_3 }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-sm-2 mt-auto">
                                    <button type="button" id="ejecutarReporte" class="btn btn-primary btn-block"><i class="fas fa-desktop mr-2"></i>Pantalla</button>
                                </div>
                            </div>
                            <div class="row">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th style="width: 200px">Fecha</th>
                                            <th>Cliente</th>
                                            <th style="width: 150px;">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($depositos))
                                            @foreach ($depositos as $deposito)
                                                <tr>
                                                    <td>{{ date('d-m-Y', strtotime($deposito->date)) }}</td>
                                                    <td>{{ $deposito->name }}</td>
                                                    <td class="text-right">{{ contabilidad($deposito->total/100) }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        <tr>
                                            <td colspan="2" class="text-right">TOTAL:</td>
                                            <td class="text-right">{{ contabilidad($acumulado/100) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@push('scripts')
    <script>
        $('#ejecutarReporte').on('click', function (e) {
            var data = $('#client').select2("val");
            console.log(data);

        @this.set('client', data);
        Livewire.emit('getResults')
        });
    </script>
@endpush
