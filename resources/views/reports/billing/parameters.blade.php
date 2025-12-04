@extends('layouts.main')

@section('title', 'Reporte de toma de lecturas')

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
                    <form action="{{ route('reportes.billing.execute') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="year">
                                        Selecciona un año:
                                    </label>
                                    <select name="year" id="year" class="form-control select2bs4" data-placeholder="Selecciona un año">
                                        <option></option>
                                        @foreach($years as $year)
                                            <option value="{{ $year }}" @selected(old('year', now()->year) == $year)>{{ $year }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="month">
                                        Selecciona un mes:
                                    </label>
                                    <select name="month" id="month" class="form-control select2bs4">
                                        <option value="01" @selected(old('month', now()->format('m')) == '01')>Enero</option>
                                        <option value="02" @selected(old('month', now()->format('m')) == '02')>Febrero</option>
                                        <option value="03" @selected(old('month', now()->format('m')) == '03')>Marzo</option>
                                        <option value="04" @selected(old('month', now()->format('m')) == '04')>Abril</option>
                                        <option value="05" @selected(old('month', now()->format('m')) == '05')>Mayo</option>
                                        <option value="06" @selected(old('month', now()->format('m')) == '06')>Junio</option>
                                        <option value="07" @selected(old('month', now()->format('m')) == '07')>Julio</option>
                                        <option value="08" @selected(old('month', now()->format('m')) == '08')>Agosto</option>
                                        <option value="09" @selected(old('month', now()->format('m')) == '09')>Septiembre</option>
                                        <option value="10" @selected(old('month', now()->format('m')) == '10')>Octubre</option>
                                        <option value="11" @selected(old('month', now()->format('m')) == '11')>Noviembre</option>
                                        <option value="12" @selected(old('month', now()->format('m')) == '12')>Diciembre</option>
                                    </select>
                                    @error('month')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="project_id">Seleccionar condominio:</label>
                                    <select class="form-control select2bs4" name="project_id" id="project_id">
                                        @foreach ($projects as $id => $project)
                                            <option value="{{ $id }}">{{ $project }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="d-block mb-2">Seleccionar columnas a mostrar:</label>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="columns[]" id="col_folio" value="folio" checked>
                                    <label class="form-check-label" for="col_folio">Folio (ID)</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="columns[]" id="col_cliente" value="cliente" checked>
                                    <label class="form-check-label" for="col_cliente">Nombre del cliente</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="columns[]" id="col_condominio" value="condominio" checked>
                                    <label class="form-check-label" for="col_condominio">Condominio</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="columns[]" id="col_edificio" value="edificio" checked>
                                    <label class="form-check-label" for="col_edificio">Edificio</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="columns[]" id="col_departamento" value="departamento" checked>
                                    <label class="form-check-label" for="col_departamento">Departamento</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="columns[]" id="col_saldo_anterior" value="saldo_anterior" disabled>
                                    <label class="form-check-label" for="col_saldo_anterior">Saldo anterior</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="columns[]" id="col_saldo_cuenta" value="saldo_cuenta" checked>
                                    <label class="form-check-label" for="col_saldo_cuenta">Saldo en cuenta</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="columns[]" id="col_total_mes" value="total_mes" checked>
                                    <label class="form-check-label" for="col_total_mes">Total del mes</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group d-flex justify-content-between">
                            <div>
                                <button type="submit" name="action" value="pdf" class="btn btn-sm btn-default">
                                    <i class="far fa-file-pdf mr-2"></i>Generar PDF</button>

                                <button type="submit" name="action" value="excel" class="btn btn-sm btn-default">
                                    <i class="far fa-file-excel mr-2"></i>Generar Excel
                                </button>
                            </div>

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
