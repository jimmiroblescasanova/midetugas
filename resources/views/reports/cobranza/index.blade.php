@extends('layouts.main')

@section('title', 'Reporte de cobranza')

@section('header')
    <div class="col-sm-6">
        <h1><i class="fas fa-user mr-2"></i>Reporte: Cobranza</h1>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div id="messageError">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <span>
                                    @error('clients')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        @endif
                    </div>
                    <form id="account-status" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="month">Corte</label>
                                    <select name="month" id="month" class="form-control">
                                        <option value="01">Enero</option>
                                        <option value="02">Febrero</option>
                                        <option value="03">Marzo</option>
                                        <option value="04">Abril</option>
                                        <option value="05">Mayo</option>
                                        <option value="06">Junio</option>
                                        <option value="07">Julio</option>
                                        <option value="08">Agosto</option>
                                        <option value="09">Septiembre</option>
                                        <option value="10">Octubre</option>
                                        <option value="11">Noviembre</option>
                                        <option value="12">Diciembre</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="year">Año</label>
                                    <select name="year" id="year" class="form-control">
                                        @foreach ($years as $i => $year)
                                            <option>{{ $year }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="select_project">Condominios</label>
                                    <select id="select_project" name="project" class="form-control select2bs4" data-placeholder="Selecciona un condominio">
                                        <option></option>
                                        @foreach ($projects as $id => $project)
                                            <option value="{{ $id }}">{{ $project }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" formtarget="_blank" formaction="{{ route('reportes.cobranza.pdf') }}" class="btn btn-sm btn-danger">
                                    <i class="fas fa-file-pdf mr-2"></i>PDF
                                </button>
                                <button type="submit" id="exportExcel" formaction="{{ route('reportes.cobranza.excel') }}"
                                    class="btn btn-sm btn-success">
                                    <i class="fas fa-file-excel mr-2"></i>Excel
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
@stop
