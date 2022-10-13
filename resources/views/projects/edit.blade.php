@extends('layouts.main')

@section('header')
    <div class="col-sm-6">
        <h1><i class="far fa-building mr-2"></i>Editar condominio</h1>
    </div>
    <div class="col-sm-6 d-flex justify-content-end">
        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deletePojectModal">
            <i class="fas fa-trash-alt mr-2"></i>Eliminar</button>
    </div>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <x-form :action="route('projects.update', $project)">
                @csrf
                @method('PATCH')
                @bind($project)
                <div class="card-body">
                    <x-form-input name="name" label="Nombre del condominio:" />
                    <x-form-input name="reference" label="Referencia:" />
                    <div class="form-group">
                        <label for="total_capacity">Capacidad total: <i class="fas fa-question-circle fa-xs"
                            data-toggle="tooltip"
                            data-placement="right"
                            title="Se calcula con la suma de los tanques asignados"></i>
                        </label>
                        <input type="text" class="form-control" readonly name="total_capacity" id="total_capacity" value="{{ $project->total_capacity }}">
                    </div>
                    <div class="text-muted text-right">
                        <small>Última modificación: {{ $project->updated_at->diffForHumans() }}</small>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <x-form-submit class="btn-sm">
                            <i class="fas fa-save mr-2"></i>Actualizar
                        </x-form-submit>
                        <x-buttons.back route="projects.index" />
                    </div>
                </div>
            </x-form>
        </div>
    </div>
</div>
@stop

@section('modal-section')
    <x-modals.delete id="deletePojectModal" :action="route('projects.destroy', $project)" />
@stop

@section('scripts')
<script>
    $(function() {
            $('[data-toggle="tooltip"]').tooltip();;
        });
</script>
@endsection
