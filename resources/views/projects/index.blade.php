@extends('layouts.main')

@section('header')
    <div class="col-sm-6">
        <h1><i class="far fa-building mr-2"></i>Condominios</h1>
    </div>
    @can('create_projects')
        <div class="col-sm-6">
            <button type="button" class="btn btn-primary btn-sm float-sm-right btn-block-xs-only" data-toggle="modal"
                data-target="#createNewProject">
                <i class="fas fa-pencil-alt mr-2"></i>Crear nuevo
            </button>
        </div>
    @endcan
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped" id="dataTableProjects">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Capacidad total (L)</th>
                                <th>Capacidad actual (L)</th>
                                <th>Porcentaje</th>
                                <th>Referencia</th>
                                <th class="text-center" style="width: 100px;"><i class="fas fa-cogs"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($projects as $project)
                                <tr>
                                    <td>{{ $project->name }}</td>
                                    <td>{{ $project->total_capacity }}</td>
                                    <td>{{ $project->actual_capacity }}</td>
                                    <td>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-green" role="progressbar"
                                                aria-volumenow="{{ $project->percentage }}" aria-volumemin="0"
                                                aria-volumemax="100" style="width: {{ $project->percentage }}%">
                                            </div>
                                        </div>
                                        <small>
                                            {{ $project->percentage }}% capacidad maxima (litros)
                                        </small>
                                    </td>
                                    <td>{{ $project->reference }}</td>
                                    <td class="text-right">
                                        <a href="{{ route('projects.edit', $project) }}" class="btn btn-xs btn-default"><i
                                                class="fas fa-edit mr-2"></i>Editar</a>
                                    </td>
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
        $(document).ready(function() {
            $('#dataTableProjects').DataTable({
                "responsive": true,
                "autoWidth": false,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
                },
            });
        });
        if (window.location.hash === '#create') {
            $('#createNewProject').modal('show');
        }

        $('#createNewProject').on('hide.bs.modal', function (){
            window.location.hash = '#';
        });

        $('#createNewProject').on('shown.bs.modal', function () {
            $('input[name="name"]').trigger('focus');
            // window.location.hash = '#create';
        });
    </script>
@stop
