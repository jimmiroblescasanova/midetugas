@extends('layouts.main')

@section('header')
    <div class="col-sm-6">
        <h1><i class="fas fa-user mr-2"></i>Editar tanque</h1>
    </div>
    <div class="col-sm-6 d-flex justify-content-end">
        <button type="submit" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteTankModal">
            <i class="fas fa-trash-alt mr-2"></i>Eliminar</button>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <x-form :action="route('tanks.update', $tank)">
                    <div class="card-body">
                        @method('PATCH')
                        @include('tanks._form')
                    </div>
                    <div class="card-footer">
                        <div class="from-group d-flex justify-content-between mb-0">
                            <button type="submit" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit mr-2"></i>Actualizar</button>
                            <a href="{{ route('tanks.index') }}" type="button" class="btn btn-sm btn-danger">
                                <i class="fas fa-hand-point-left mr-2"></i>Cancelar</a>
                        </div>
                    </div>
                </x-form>
            </div>
        </div>
    </div>
@stop

@section('modal-section')
    <x-modals.delete id="deleteTankModal" :action="route('tanks.destroy', $tank)" />
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
