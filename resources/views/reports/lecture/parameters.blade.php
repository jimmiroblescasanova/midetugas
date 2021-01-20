@extends('layouts.main')

@section('header')
    <div class="col-sm-6">
        <h1><i class="fas fa-user"></i> Parámetros: Reporte 1</h1>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('report01.show') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="project_id">Seleccionar condominio:</label>
                                    <select class="form-control select2bs4" name="project_id" id="project_id" data-placeholder="Selecciona un condominio">
                                        <option value=""></option>
                                        @foreach($projects as $project)
                                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                                        @endforeach
                                    </select>
                                    <small id="helpId" class="form-text text-muted">Help text</small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="order">Orden:</label>
                                    <select class="form-control" name="order" id="order">
                                        <option value="ASC">Ascendente: A-Z</option>
                                        <option class="DESC">Descendente: Z-A</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-sm btn-default">Enviar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')

@stop
