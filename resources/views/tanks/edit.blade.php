@extends('layouts.main')

@section('header')
    <div class="col-sm-6">
        <h1><i class="fas fa-user mr-2"></i>Editar tanque</h1>
    </div>
    <div class="col-sm-6 d-flex justify-content-end">
        <form action="{{ route('tanks.destroy', $tank) }}" method="POST">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt mr-2"></i>Eliminar</button>
        </form>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('tanks.update', $tank) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        @include('tanks._form')
                        <div class="from-group d-flex justify-content-between">
                            <button type="submit" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit mr-2"></i>Actualizar</button>
                            <button type="button" class="btn btn-sm btn-danger" onclick="history.back();">
                                <i class="fas fa-hand-point-left mr-2"></i>Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop


@section('scripts')
    <script>
        let today, datepicker;
        today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
        datepicker = $('.datepicker').datepicker({
            locale: 'es-es',
            format: 'yyyy-mm-dd',
            uiLibrary: 'bootstrap4',
        });
    </script>
@stop
