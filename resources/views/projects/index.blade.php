@extends('layouts.main')

@section('header')
    <div class="col-sm-6">
        <h1><i class="far fa-building"></i> Condominios</h1>
    </div>
    <div class="col-sm-6">
        <button type="button" class="btn btn-primary btn-sm float-sm-right btn-block-xs-only"
                data-toggle="modal" data-target="#createNewProject">
            <i class="fas fa-pencil-alt"></i> Crear nuevo
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
                            <th>Nombre</th>
                            <th>Capacidad total</th>
                            <th>Capacidad actual</th>
                            <th>Porcentaje</th>
                            <th>Acción</th>
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
                                        <div class="progress-bar bg-green"
                                             role="progressbar"
                                             aria-volumenow="{{ $project->percentage }}"
                                             aria-volumemin="0"
                                             aria-volumemax="100"
                                             style="width: {{ $project->percentage }}%">
                                        </div>
                                    </div>
                                    <small>
                                        {{ $project->percentage }}% capacidad maxima
                                    </small>
                                </td>
                                <td></td>
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
                <form action="{{ route('projects.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input type="text" class="form-control" name="name" id="name" autofocus>
                        </div>
                        <div class="form-group">
                            <label for="reference">Referencia</label>
                            <input type="text" class="form-control" name="reference" id="reference">
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

@stop
