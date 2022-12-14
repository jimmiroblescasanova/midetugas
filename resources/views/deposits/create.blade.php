@extends('layouts.main')

@section('title', 'Nuevo deposito')

@section('header')
    <div class="col-sm-6">
        <h1><i class="fas fa-user mr-2"></i>Capturar depósito</h1>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <x-form :action="route('deposits.store')">
                        <div class="row">
                            <div class="col-md-3">
                                <x-form-input type="date" name="date" label="Seleccionar fecha:">
                                    @slot('prepend')
                                    <i class="fas fa-calendar-alt"></i>
                                    @endslot
                                </x-form-input>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="contract_number">Contrato:</label>
                                    <input type="text" name="contract_number" id="contract_number"
                                        class="form-control {{ $errors->first('contract_number') ? 'is-invalid' : '' }}"
                                        placeholder="No. de contrato">
                                    {!! $errors->first('contract_number', '<div class="invalid-feedback">:message</div>') !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="type">Tipo:</label>
                                    <select name="type" id="type"
                                        class="form-control select2bs4 {{ $errors->first('type') ? 'is-invalid' : '' }}">
                                        <option value="Doméstico">Doméstico</option>
                                        <option value="Comercial">Comercial</option>
                                    </select>
                                    {!! $errors->first('type', '<div class="invalid-feedback">:message</div>') !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="total">Total:</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">$</span>
                                        </div>
                                        <input type="text"
                                            class="form-control {{ $errors->first('total') ? 'is-invalid' : '' }}"
                                            name="total" id="total">
                                    </div>
                                    {!! $errors->first('total', '<div class="invalid-feedback">:message</div>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="client_id">Seleccionar cliente:</label>
                            <select name="client_id" id="client_id"
                                class="form-control select2bs4 {{ $errors->first('client_id') ? 'is-invalid' : '' }}"
                                data-placeholder="Selecciona una opción">
                                <option></option>
                                @foreach ($clients as $id => $client)
                                    <option value="{{ $id }}">{{ $client }}</option>
                                @endforeach
                            </select>
                            {!! $errors->first('client_id', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                        <div class="form-group">
                            <label for="tax_address">Dirección fiscal:</label>
                            <textarea name="tax_address" id="tax_address" rows="2" class="form-control"></textarea>
                        </div>
                        <div class="form-group d-flex justify-content-between">
                            <button type="submit" class="btn btn-sm btn-primary btn-block-xs-only">
                                <i class="fas fa-save mr-2"></i>Guardar</button>
                            <x-buttons.back route="deposits.index"/>
                        </div>
                    </x-form>
                </div>
            </div>
        </div>
    </div>
@stop
