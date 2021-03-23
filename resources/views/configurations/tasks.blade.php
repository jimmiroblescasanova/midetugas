@extends('layouts.main')

@section('header')
    <div class="col-sm-6">
        <h1><i class="fas fa-user"></i> Procesos especiales</h1>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h3>Recalcular capacidad actual</h3>
                    <p>Este proceso realiza un recalculado de las entradas y salidas de el condominio seleccionado. <br/>
                        <small class="text-muted">*Se utiliza para corregir entradas a destiempo o negativos.</small>
                    </p>
                    <form action="{{ route('configurations.run.recalcularInventario') }}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <label for="project_id" class="col-form-label col-md-4">Seleccionar condominio a recalcular</label>
                            <div class="col-md-7">
                                <select class="form-control" name="project_id" id="project_id">
                                    @foreach($projects as $project => $id)
                                        <option value="{{ $id }}">{{ $project }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Procesar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')

@stop
