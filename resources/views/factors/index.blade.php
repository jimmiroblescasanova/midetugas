@extends('layouts.main')

@section('title', 'Factor de corrección')

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
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Factor PSIG</th>
                                <th>Valor</th>
                                <th style="width: 200px;">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($factors as $factor)
                                <tr>
                                    <td scope="row">{{ $factor->psig }} PSIG</td>
                                    <td>{{ $factor->value }}</td>
                                    <td class="text-right">
                                        <a href="{{ route('factors.edit', $factor) }}" class="btn btn-xs btn-default">
                                            <i class="fas fa-pencil-alt mr-2"></i>Editar
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {{ $factors->links() }}
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
                    <h5 class="modal-title">Capturar nuevo</h5>
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

@section('scripts')
    <script>
        $('#modalDelete').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var modal = $(this);

            modal.find('.modal-footer input[name=id]').val(id);
        });
    </script>
@stop
