@extends('layouts.main')

@section('header')
<div class="col-sm-6">
    <h1><i class="far fa-building mr-2"></i>Editar condominio</h1>
</div>
<div class="col-sm-6 d-flex justify-content-end">
    <button type="submit" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deletePoject">
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
                        <a href="{{ route('projects.index') }}" class="btn btn-sm btn-danger">
                            <i class="fas fa-hand-point-left mr-2"></i>Atrás</a>
                    </div>
                </div>
            </x-form>
        </div>
    </div>
</div>
@stop

@section('modal-section')
<!-- Modal -->
<div class="modal fade" id="deletePoject" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">¿Estas seguro?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-footer">
                <x-form :action="route('projects.destroy', $project)">
                    @method('DELETE')
                    <button type="button" class="btn btn-default" data-dismiss="modal">No, cancelar</button>
                    <x-form-submit class="btn-danger">Si, eliminar!</x-form-submit>
                </x-form>
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
