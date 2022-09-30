@extends('layouts.main')

@section('header')
    <div class="col-sm-6">
        <h1><i class="fas fa-user mr-2"></i>Reporte: Cobranza</h1>
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
                    <form id="account-status" target="_blank" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="month">Corte</label>
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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="client_first">Seleccionar cliente inicial</label>
                                    <select name="client_first" id="client_first" class="select2bs4 form-control">
                                        @foreach ($clients as $id => $client)
                                            <option value="{{ $id }}">{{ $client }} ({{ $id }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="client_last">Seleccionar cliente final</label>
                                    <select name="client_last" id="client_last" class="select2bs4 form-control">
                                        @foreach ($clients as $id => $client)
                                            <option value="{{ $id }}">{{ $client }} ({{ $id }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="submit" id="execute" class="btn btn-sm btn-primary">
                            <i class="fas fa-desktop mr-2"></i>Pantalla</button>
                        <button type="submit" formaction="{{ route('reportes.cobranza.pdf') }}" class="btn btn-sm btn-danger"><i
                                class="fas fa-file-pdf mr-2"></i>PDF</button>
                        <button type="submit" id="exportExcel" formaction="{{ route('reportes.cobranza.excel') }}"
                            class="btn btn-sm btn-success">
                            <i class="fas fa-file-excel mr-2"></i>Excel</button>
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
                                <th>Cliente</th>
                                <th>Departamento</th>
                                <th>Total</th>
                                <th>Abonos</th>
                                <th>Saldo</th>
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
        $("#execute").click(function(event) {
            event.preventDefault();
            const token = $('meta[name="csrf-token"]').attr('content');
            let route = "{{ route('reportes.cobranza.screen') }}";
            let data = $('#account-status').serialize();

            $.ajax({
                type: 'POST',
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                data: data,
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    let rows = data.documents;
                    let html = "";
                    $.each(rows, function(i, val) {
                        // console.log(val.id);
                        html += "<tr><td>" + val.client.name + "</td>" +
                            "<td>"+ val.client.line_3 +"</td>"+
                            "<td>" + numeral(val.suma / 100).format('$0,0.00') + "</td>" +
                            "<td class='text-right'>" + numeral((val.suma - val.pendiente) /
                                100)
                            .format('$0,0.00') +
                            "</td>" +
                            "<td class='text-right'>" + numeral(val.pendiente / 100).format(
                                '$0,0.00') +
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
