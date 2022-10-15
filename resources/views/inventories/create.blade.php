@extends('layouts.main')

@section('header')
    <div class="col-sm-6">
        <h1><i class="fas fa-boxes mr-2"></i>Inventarios</h1>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <x-form :action="route('inventories.store')">
                    <div class="card-body">
                        <input type="hidden" name="user" value="{{ auth()->user()->name }}">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <x-form-select name="project_id" class="select2bs4" :options="$projects" id="project_id" label="Condominio:" />
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="tank_id">Tanque:</label>
                                    <select class="form-control select2bs4 {{ $errors->first('tank_id') ? 'is-invalid' : '' }}" name="tank_id"
                                        id="tank_id">
                                        <option></option>
                                    </select>
                                    {!! $errors->first('tank_id', '<div class="invalid-feedback">:message</div>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <x-form-input type="date" name="date" label="Fecha de ingreso:">
                                    @slot('prepend')
                                    <i class="fas fa-calendar-alt"></i>
                                    @endslot
                                </x-form-input>
                            </div>
                            <div class="col-12 col-md-6">
                                <x-form-input type="number" step="0.01" name="quantity" label="Cantidad (L):">
                                    @slot('prepend')
                                    <i class="fas fa-gas-pump"></i>
                                    @endslot
                                </x-form-input>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="form-group d-flex justify-content-between mb-0">
                            <x-form-submit class="btn-sm">
                                <i class="fas fa-save mr-2"></i>Guardar
                            </x-form-submit>
                            <x-buttons.back route="inventories.index" />
                        </div>
                    </div>
                </x-form>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#project_id').on('change', function(e) {
                let id = e.target.value;

                $.ajax({
                    url: "/api/inventories/fill-tank",
                    type: "POST",
                    data: {
                        project_id: id
                    },
                    success: function(data) {
                        $('#tank_id').empty();
                        $.each(data.data, function(index, tank) {
                            console.log(tank);
                            $('#tank_id').append('<option value="' + tank.id + '">' +
                                tank.brand + ' - ' + tank.model + ' - ' + tank
                                .serial_number + '</option>');
                        });
                    }
                });

            });
        });
    </script>
@stop
