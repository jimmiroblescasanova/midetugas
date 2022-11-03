@extends('layouts.main')

@section('title', 'Todos los pagos')

@section('header')
    <div class="col-sm-6">
        <h1><i class="fas fa-hand-holding-usd mr-2"></i>Lista de Pagos</h1>
    </div>
    <div class="col-sm-6">
        <button type="button" class="btn btn-primary btn-sm float-sm-right btn-block-xs-only" data-toggle="modal"
            data-target="#new_payment">
            <i class="fas fa-pencil-alt mr-2"></i>Crear nuevo</button>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
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
                <form action="{{ route('payments.createForm') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            @livewire('search-clients')
                            {{-- <label for="">Seleccionar un cliente</label>
                            <select class="form-control select2" name="client" id="client">
                                @foreach ($clients as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select> --}}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Seleccionar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
