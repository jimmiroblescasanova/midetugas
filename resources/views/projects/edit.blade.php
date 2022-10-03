@extends('layouts.main')

@section('header')
    <div class="col-sm-6">
        <h1><i class="far fa-building mr-2"></i>Editar condominio</h1>
    </div>
    <div class="col-sm-6 d-flex justify-content-end">
        <form action="{{ route('projects.destroy', $project) }}" method="POST">
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
                    <form action="{{ route('projects.update', $project) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label for="name">Nombre del condominio</label>
                            <input type="text" class="form-control" name="name" id="name"
                                value="{{ $project->name }}">
                        </div>
                        <div class="form-group">
                            <label for="reference">Referencia</label>
                            <input type="text" class="form-control" name="reference" id="reference"
                                value="{{ $project->reference }}">
                        </div>
                        <div class="form-group">
                            <label for="total_capacity">Capacidad total <i class="fas fa-question-circle fa-xs"
                                    data-toggle="tooltip" data-placement="right"
                                    title="Se calcula con la suma de los tanques asignados"></i>
                            </label>
                            <input type="text" class="form-control" readonly name="total_capacity" id="total_capacity"
                                value="{{ $project->total_capacity }}">
                        </div>
                        <div class="form-group d-flex justify-content-between">
                            <button type="submit" class="btn btn-sm btn-primary">
                                <i class="fas fa-save mr-2"></i>Actualizar</button>
                            <a href="{{ route('projects.index') }}" class="btn btn-sm btn-danger">
                                <i class="fas fa-hand-point-left mr-2"></i>Atrás</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip();;
        });
    </script>
@endsection
