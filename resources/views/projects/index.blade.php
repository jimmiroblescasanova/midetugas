@extends('layouts.main')

@section('title', 'Todos los condominios')

@section('header')
    <div class="col-sm-6">
        <h1><i class="far fa-building mr-2"></i>Condominios</h1>
    </div>
    @can('create_projects')
        <div class="col-sm-6 d-flex justify-content-end">
            <button type="button" class="btn btn-primary btn-sm btn-block-xs-only" data-toggle="modal"
                data-target="#createNewProject">
                <i class="fas fa-pencil-alt mr-2"></i>Crear nuevo
            </button>
        </div>
    @endcan
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            @livewire('tables.projects')
        </div>
    </div>
@stop

@section('modal-section')
    <div class="modal fade" id="createNewProject">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Capturar nuevo condominio</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <x-form :action="route('projects.store', '#create')">
                    @csrf
                    <div class="modal-body">
                        <x-form-input name="name" label="Nombre del condominio:" />
                        <x-form-input name="reference" label="Referencia:" />
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="submit" class="btn btn-sm btn-primary">
                            <i class="fas fa-save mr-2"></i>Guardar
                        </button>
                        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">
                            <i class="fas fa-ban mr-2"></i>Cancelar
                        </button>
                    </div>
                </x-form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
@stop

@section('scripts')
    <script>
        if (window.location.hash === '#create') {
            $('#createNewProject').modal('show');
        }

        $('#createNewProject').on('hide.bs.modal', function (){
            window.location.hash = '#';
        });

        $('#createNewProject').on('shown.bs.modal', function () {
            $('input[name="name"]').trigger('focus');
        });
    </script>
@stop
