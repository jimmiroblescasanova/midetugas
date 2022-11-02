@extends('layouts.main')

@section('title', 'Editar tanque')

@section('header')
    <div class="col-sm-6">
        <h1><i class="fas fa-project-diagram mr-2"></i>Editar tanque</h1>
    </div>
    <div class="col-sm-6">
        <button type="button" class="btn btn-sm btn-danger float-right" data-toggle="modal" data-target="#deleteTankModal">
            <i class="fas fa-trash-alt mr-2"></i>Eliminar</button>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <x-form :action="route('tanks.update', $tank)">
                    <div class="card-body">
                        @method('PATCH')
                        @include('tanks._form')
                        <div class="text-muted text-right">
                            <small>Última modificación: {{ $tank->updated_at->diffForHumans() }}</small>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="from-group d-flex justify-content-between mb-0">
                            <x-form-submit class="btn-sm">
                                <i class="fas fa-edit mr-2"></i>Actualizar
                            </x-form-submit>
                            <x-buttons.back route="tanks.index" />
                        </div>
                    </div>
                </x-form>
            </div>
        </div>
    </div>
@stop

@section('modal-section')
    <x-modals.delete id="deleteTankModal" :action="route('tanks.destroy', $tank)" />
@stop

