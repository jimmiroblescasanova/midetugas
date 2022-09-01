@extends('layouts.main')

@section('header')
    <div class="col-sm-6">
        <h1><i class="fas fa-home mr-2"></i>Factores de corrección</h1>
    </div>
    <div class="col-sm-6">
        <button type="button" class="btn btn-primary btn-sm float-sm-right btn-block-xs-only" data-toggle="modal"
            data-target="#newFactor">
            <i class="fas fa-pencil-alt mr-2"></i>Crear nuevo
        </button>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Factor PSIG</th>
                                <th>Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($factors as $factor)
                                <tr>
                                    <td scope="row">{{ $factor->psig }}</td>
                                    <td>{{ $factor->value }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('modal-section')
    <div class="modal fade" id="newFactor">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Capturar nuevo precio</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('factors.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-12 col-sm-12">
                                <label for="psig">Factor PSIG</label>
                                <input type="text" class="form-control" name="psig" id="psig"
                                    placeholder="Ingresa el factor de corrección">
                            </div>
                            <div class="form-group col-12 col-sm-12">
                                <label for="value">Valor</label>
                                <input type="number" step="any" class="form-control" name="value" id="value"
                                    placeholder="Ingresa el valor">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="submit" class="btn btn-sm btn-primary">Guardar</button>
                        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
@stop
