@extends('layouts.main')

@section('header')
    <div class="col-sm-6">
        <h1><i class="fas fa-user mr-2"></i>Crear tanque</h1>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <x-form :action="route('tanks.store')">
                    <div class="card-body">
                        @csrf
                        @include('tanks._form')
                    </div>
                    <div class="card-footer">
                        <div class="form-group d-flex justify-content-between mb-0">
                            <button type="submit" class="btn btn-sm btn-primary btn-block-xs-only">
                                <i class="fas fa-save mr-2"></i>Guardar
                            </button>
                            <a href="{{ route('tanks.index') }}" class="btn btn-sm btn-danger">
                                <i class="fas fa-hand-point-left mr-2"></i>Cancelar</a>
                        </div>
                    </div>
                </x-form>
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
            // format: 'yyyy-mm-dd',
            uiLibrary: 'bootstrap4',
        });
    </script>
@stop
