@extends('layouts.main')

@section('title', 'Todos los pagos')

@section('header')
    <div class="col-sm-6">
        <h1><i class="fas fa-hand-holding-usd mr-2"></i>Lista de Pagos</h1>
    </div>
    <div class="col-sm-6">
        @if (!$unclosedPayments >= 1)
        <button type="button" class="btn btn-primary btn-sm float-sm-right btn-block-xs-only" data-toggle="modal" data-target="#new_payment">
            <i class="fas fa-pencil-alt mr-2"></i>Crear nuevo
        </button>
        @endif
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
        @if ($unclosedPayments >= 1)
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                <span class="sr-only">Close</span>
            </button>
            <strong>Pagos pendientes!</strong> Existen pagos sin cerrar, primero finaliza la captura para crear nuevos pagos.
        </div>
        @endif
            @livewire('tables.payments')
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="new_payment" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Seleccionar cliente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('payments.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <select class="form-control select2bs4" id="projects_list" data-placeholder="Selecciona un condominio...">
                                <option></option>
                                @foreach ($projects as $id => $project)
                                    <option value="{{ $id }}">{{ $project }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <select name="client" class="form-control select2bs4" id="clients_list" data-placeholder="Primero selecciona un condominio...">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="date" class="form-control" name="date">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="amount" placeholder="Ingresa la cantidad del pago" data-type="currency">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Continuar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script>
        $("#projects_list").on('change', function() {
            let selectedProject = $(this).val();

            $.ajax({
                type: 'POST',
                url: '/api/clients-from-project',
                data: {
                project: selectedProject,
                },
                success: function(data) {
                    let select = $('#clients_list');
                    select.empty();

                    $.each(data, function(key, value) {
                        select.append($('<option>', {
                            value: value.id,
                            text: `${value.name} - ${value.shortName}`,
                        }));
                    });
                },
                error: function(error) {
                    console.log('An error occurred: ' + error)
                }
            });
        });
    </script>
@endsection