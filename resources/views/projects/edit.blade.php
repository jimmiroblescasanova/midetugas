@extends('layouts.main')

@section('header')
    <div class="col-sm-6">
        <h1><i class="far fa-building mr-2"></i>Editar condominio</h1>
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
                            {{-- <small id="helpId" class="form-text text-muted">Help text</small> --}}
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
                        <div class="form-group">
                            <button type="submit" class="btn btn-sm btn-primary">
                                <i class="fas fa-save mr-2"></i>Actualizar</button>
                            <button type="button" class="btn btn-sm btn-danger" onclick="history.back();">
                                <i class="fas fa-hand-point-left mr-2"></i>Atrás</button>
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
