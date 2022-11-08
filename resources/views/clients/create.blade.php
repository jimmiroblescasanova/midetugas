@extends('layouts.main')

@section('title', 'Crear clientes')

@section('header')
    <div class="col-sm-6">
        <h1><i class="fas fa-users"></i> Nuevo cliente</h1>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header card-outline card-primary">
                    Formulario de alta de cliente nuevo
                </div>
                <form action="{{ route('clients.store') }}" role="form" method="POST">
                    <div class="card-body">
                        @csrf
                        <fieldset class="border p-3 mb-3">
                            <legend class="w-auto px-3">Datos generales</legend>
                            @include('clients.forms.general')
                        </fieldset>
                        <fieldset class="border p-3 mb-3">
                            <legend class="w-auto px-3">Domicilio del cliente</legend>
                            @include('clients.forms.address')
                        </fieldset>
                        <fieldset class="border p-3 mb-3">
                            <legend class="w-auto px-3">Datos de los contactos</legend>
                            @include('clients.forms.contacts')
                        </fieldset>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-sm btn-primary">Guardar datos del cliente</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('scripts')
<script>
    let SinMedidor = document.getElementById('SinMedidor');

    $('#measurer_id').select2({
        theme: 'bootstrap4',
    });

    SinMedidor.addEventListener('click', () => {
        $('#measurer_id').prop('disabled', SinMedidor.checked);
    });
</script>
@stop
