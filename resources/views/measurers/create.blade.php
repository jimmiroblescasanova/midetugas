@extends('layouts.main')

@section('header')
    <div class="col-sm-6">
        <h1><i class="fas fa-tachometer-alt mr-2"></i>Alta de medidor</h1>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <x-form :action="route('measurers.store')">
                    <div class="card-body">
                        @csrf
                        @include('measurers._form')
                        <div class="row">
                            <div class="col-sm-6">
                                <x-form-input name="actual_measure" label="Consumo actual (m3)" />
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="from-group d-flex justify-content-between mb-0">
                            <x-form-submit class="btn-sm">
                                <i class="fas fa-save mr-2"></i>Actualizar
                            </x-form-submit>
                            <x-buttons.back route="measurers.index" />
                        </div>
                    </div>
                </x-form>
            </div>
        </div>
    </div>
@stop
