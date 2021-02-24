@extends('layouts.main')

@section('header')
    <div class="col-sm-6">
        <h1><i class="fas fa-user"></i> Reporte: Saldos de clientes</h1>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form id="account-status">
                        @csrf
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="month">Periodo</label>
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
                                        @foreach($years as $i)
                                            <option value="{{ $i->year }}">{{ $i->year }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="client_first">Seleccionar cliente inicial</label>
                                    <select name="client_first" id="client_first" class="form-control">
                                        @foreach($clients as $id => $client)
                                            <option value="{{ $id }}">{{ $client }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="client_last">Seleccionar cliente final</label>
                                    <select name="client_last" id="client_last" class="form-control">
                                        @foreach($clients as $id => $client)
                                            <option value="{{ $id }}">{{ $client }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div id="messageError" class="row">

                        </div>
                        <button type="submit" id="execute" class="btn btn-sm btn-primary"><i class="fas fa-desktop"></i> Pantalla</button>
                        <button type="submit" formaction="/action_two" id="" class="btn btn-sm btn-success"><i class="fas fa-file-excel"></i> Excel</button>
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
                            <th>Folio</th>
                            <th>Cliente</th>
                            <th>Total</th>
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
    <script>
        $("#execute").click(function(event){
            event.preventDefault();
            const token = $('meta[name="csrf-token"]').attr('content');
            let route = "{{ route('ajax.accountStatus') }}";
            let data = $('#account-status').serialize();
            $('#messageError').html("");

            $.ajax({
                type: 'POST',
                url: route,
                headers: {'X-CSRF-TOKEN': token},
                data: data,
                dataType: 'json',
                success: function (data) {
                    // console.log(data);
                    let rows = data.documents;
                    let html = "";
                    $.each(rows, function(i, val){
                        // console.log(val.id);
                        html += "<tr><td>"+val.id+"</td>" +
                            "<td>"+val.client.name+"</td>" +
                            "<td>"+val.total+"</td>" +
                            "<td>"+val.pending+"</td>" +
                            "</tr>";
                    });
                    $('#result>tbody').html(html);
                },
                error: function (data) {
                    let message = JSON.parse(data.responseText);
                    $('#messageError').html("<li>"+ message.error +"</li>");
                },
            });
        });
    </script>
@stop
