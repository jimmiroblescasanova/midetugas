@extends('layouts.main')

@section('title', 'Ver ingreso de inventario')

@section('header')
    <div class="col-sm-6">
        <h1><i class="fas fa-boxes mr-2"></i>Entrada de inventario</h1>
    </div>
    <div class="col-sm-6">
        <button type="button" class="btn btn-sm btn-danger float-right" data-toggle="modal"
            data-target="#deleteInventoryModal">
            <i class="fas fa-trash-alt mr-2"></i>Eliminar</button>
    </div>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-2 d-flex justify-content-center">
                        <i class="fas fa-truck fa-5x"></i>
                    </div>
                    <div class="col-10">
                        <div class="row">
                            <div class="col-6">
                                <div class="media">
                                    <span class="align-self-center mr-3"><i class="fas fa-calendar-alt fa-3x"></i></span>
                                    <div class="media-body form-group">
                                        <label for="date">Fecha:</label>
                                        <input type="text" id="date" class="form-control-plaintext" value="{{ $inventory->date->format('d/m/Y') }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="media">
                                    <span class="align-self-center mr-3"><i class="fas fa-calculator fa-3x"></i></span>
                                    <div class="media-body form-group">
                                        <label for="quantity">Cantidad:</label>
                                        <input type="text" id="quantity" class="form-control-plaintext"
                                            value="{{ number_format($inventory->quantity, 2) }} L" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="media">
                                    <span class="align-self-center mr-3"><i class="fas fa-building fa-3x"></i></span>
                                    <div class="form-group media-body">
                                        <label for="project">Condominio:</label>
                                        <input type="text" id="project" class="form-control-plaintext" value="{{ $inventory->project->name }}" readonly>
                                    </div>
                                </div>
                                <div class="text-muted text-right">
                                    <small>Creado: {{ $inventory->updated_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        </div>
                        <fieldset class="border p-2">
                            <legend class="float-none w-auto">Datos del tanque</legend>
                            <div class="row">
                                <div class="col-6">
                                    <x-form-input name="tank.serial_number" :bind="$inventory" label="Número de serie:" readonly>
                                        @slot('prepend')
                                        <i class="fas fa-barcode"></i>
                                        @endslot
                                    </x-form-input>
                                </div>
                                <div class="col-6">
                                    <x-form-input name="tank.model" :bind="$inventory" label="Modelo:" readonly>
                                        @slot('prepend')
                                        <i class="fas fa-code"></i>
                                        @endslot
                                    </x-form-input>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
            <div class="card-footer text-right">
                <x-buttons.back route="inventories.index" />
            </div>
        </div>
    </div>
</div>
@stop

@section('modal-section')
<x-modals.delete id="deleteInventoryModal" :action="route('inventories.destroy', $inventory)" />
@endsection
