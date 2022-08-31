@extends('layouts.main')

@section('header')
    <div class="col-sm-6">
        <h1><i class="fas fa-user mr-2"></i>Reporte: Estado de Cuenta</h1>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div id="messageError">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <span>
                                    @error('client_first')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        @endif
                    </div>
                    <form id="edcForm" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="month">Periodo inicial</label>
                                    <select name="month" id="month" class="form-control">
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
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="year">Año</label>
                                    <select name="year" id="year" class="form-control">
                                        @foreach ($years as $i)
                                            <option value="{{ $i->year }}">{{ $i->year }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="client">Seleccionar cliente</label>
                                    <select name="client" id="client" class="form-control">
                                        @foreach ($clients as $id => $client)
                                            <option value="{{ $id }}">{{ $client }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" name="allClients"
                                                id="allClients" value="1">
                                            Todos los clientes
                                        </label>
                                    </div>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input" name="allDocuments"
                                            id="allDocuments" value="1">
                                        Incluir documentos saldo cero
                                    </label>
                                </div>
                            </div>
                        </div>
                        <button type="submit" id="execute" class="btn btn-sm btn-primary">
                            <i class="fas fa-desktop mr-2"></i>Pantalla
                        </button>
                        <button type="submit" id="exportExcel" formaction="{{ route('edc.excel') }}"
                            class="btn btn-sm btn-success"><i class="fas fa-file-excel mr-2"></i>Excel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="result" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Fecha de captura</th>
                                <th>Folio</th>
                                <th>Mes</th>
                                <th>Cargo</th>
                                <th>Abono</th>
                                <th>Saldo total</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
    <script>
        var checkbox = document.getElementById('allClients');
        checkbox.addEventListener("change", disableClient, false);

        function disableClient() {
            var checked = checkbox.checked;
            document.getElementById("client").disabled = checked;
            document.getElementById("execute").disabled = checked;
        }

        $("#execute").click(function(event) {
            event.preventDefault();
            const token = $('meta[name="csrf-token"]').attr('content');
            let route = "{{ route('edc.screen') }}";
            let data = $('#edcForm').serialize();

            $.ajax({
                type: 'POST',
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                data: data,
                dataType: 'json',
                success: function(data) {
                    // console.log(data);
                    let rows = data.documents;
                    let html = "";
                    var saldo = 0;
                    $.each(rows, function(i, val) {
                        var fecha = new Date(Date.parse(val.created_at));
                        var abono = val.total - val.pending;
                        // console.log(fecha.toLocaleDateString());
                        saldo += val.pending;

                        html += "<tr><td>" + fecha.toLocaleDateString() + "</td>" +
                            "<td>" + val.id + "</td>" +
                            "<td>" + val.period + "</td>" +
                            "<td class='text-right'>" + numeral(val.total).format('$0,0.00') +
                            "</td>" +
                            "<td class='text-right'>" + numeral(abono).format('$0,0.00') +
                            "</td>" +
                            "<td class='text-right'>" + numeral(saldo).format('$0,0.00') +
                            "</td>" +
                            "</tr>";
                    });
                    $('#result>tbody').html(html);
                },
                error: function(data) {
                    console.log(data);
                    $('#messageError').html(
                        '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> El cliente inicial no puede ser mayor que el cliente final</div>'
                    );
                },
            });
        });
    </script>
@stop
