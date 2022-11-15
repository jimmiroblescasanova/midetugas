@extends('layouts.main')

@section('title', 'Editar medidor')

@section('header')
    <div class="col-sm-6">
        <h1><i class="fas fa-tachometer-alt mr-2"></i>Editar medidor</h1>
    </div>
    @can('delete_measurers')
        <div class="col-sm-6">
            <button type="button" class="btn btn-sm btn-danger float-right" data-toggle="modal" data-target="#deleteMeasurerModal">
                <i class="fas fa-trash-alt mr-2"></i>Eliminar</button>
        </div>
    @endcan
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form role="form" action="{{ route('measurers.update', $measurer) }}" method="POST">
                    <div class="card-body">
                        @csrf
                        @method('patch')
                        @include('measurers._form')
                        <div class="row">
                            <div class="col-6">
                                <x-form-input name="actual_measure" :bind="$measurer" label="Lectura actual:"></x-form-input>
                            </div>
                            <div class="col-6 align-self-end">
                                <div class="text-muted text-right">
                                    <small>Última modificación: {{ $measurer->updated_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="from-group d-flex justify-content-between mb-0">
                            <x-form-submit class="btn-sm">
                                <i class="fas fa-edit mr-2"></i>Actualizar
                            </x-form-submit>
                            <x-buttons.back route="measurers.index" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('modal-section')
    <x-modals.delete id="deleteMeasurerModal" :action="route('measurers.destroy', $measurer)" />
@endsection
