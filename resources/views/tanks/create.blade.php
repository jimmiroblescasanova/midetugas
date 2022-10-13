@extends('layouts.main')

@section('header')
    <div class="col-sm-6">
        <h1><i class="fas fa-user mr-2"></i>Crear tanque</h1>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <x-form :action="route('tanks.store')">
                    <div class="card-body">
                        @csrf
                        @include('tanks._form')
                    </div>
                    <div class="card-footer">
                        <div class="form-group d-flex justify-content-between mb-0">
                            <x-form-submit class="btn-sm">
                                <i class="fas fa-save mr-2"></i>Guardar
                            </x-form-submit>
                            <x-buttons.back route="tanks.index" />
                        </div>
                    </div>
                </x-form>
            </div>
        </div>
    </div>
@stop
