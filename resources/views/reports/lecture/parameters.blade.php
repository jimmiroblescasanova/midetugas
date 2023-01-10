@extends('layouts.main')

@section('title', 'Reporte de toma de lecturas')

@section('header')
    <div class="col-sm-6">
        <h1><i class="fas fa-user mr-2"></i>Reporte: Toma de lecturas</h1>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form target="_blank" action="{{ route('reportes.tomaDeLectura.show') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="project_id">Seleccionar condominio:</label>
                                    <select class="form-control select2bs4" name="project_id" id="project_id"
                                        data-placeholder="Selecciona un condominio">
                                        <option></option>
                                        @foreach ($projects as $project)
                                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="order">Orden:</label>
                                    <select class="form-control" name="order" id="order">
                                        <option value="ASC">Ascendente: A-Z</option>
                                        <option value="DESC">Descendente: Z-A</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group d-flex justify-content-between">
                            <button type="submit" class="btn btn-sm btn-default">
                                <i class="far fa-file-pdf mr-2"></i>Generar</button>
                            <x-buttons.back />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')

@stop
