@extends('layouts.main')

@section('title', 'Descarga masiva PDF')

@section('header')
    <div class="col-sm-6">
        <h1><i class="far fa-file-pdf mr-2"></i>Descargar PDF masivamente</h1>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('procesos.multiPdf') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-12 col-sm-6">
                                <label>Selecctiona uno o varios condominios</label>
                                <select multiple class="form-control" name="projects[]" style="height: 250px">
                                    @foreach ($proyects as $id => $proyect)
                                        <option value="{{ $id }}">{{ $proyect }}</option>
                                    @endforeach
                                </select>
                                {!! $errors->first('projects', '<div class="invalid-feedback">:message</div>') !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12 col-sm-6">
                                <label for="startDate">Selecciona una fecha inicial</label>
                                <input type="text"
                                    class="form-control datepicker {{ $errors->first('startDate') ? 'is-invalid' : '' }}"
                                    name="startDate" id="startDate" value="{{ old('startDate') }}">
                                {!! $errors->first('startDate', '<div class="invalid-feedback">:message</div>') !!}
                            </div>
                            <div class="form-group col-12 col-sm-6">
                                <label for="endDate">Selecciona una fecha final</label>
                                <input type="text"
                                    class="form-control datepicker {{ $errors->first('endDate') ? 'is-invalid' : '' }}"
                                    name="endDate" id="endDate" value="{{ old('endDate') }}">
                                {!! $errors->first('endDate', '<div class="invalid-feedback">:message</div>') !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email">Correo electrónico</label>
                            <input type="text" class="form-control {{ $errors->first('email') ? 'is-invalid' : '' }}"
                                name="email" id="email" placeholder="example@mail.com" value="{{ old('email') }}">
                            {!! $errors->first('email', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                        <div class="from-group">
                            <button type="submit" class="btn btn-sm btn-primary btn-block-xs-only">Solicitar
                                descarga</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script>
        $('#startDate').datepicker({
            locale: 'es-es',
            format: 'yyyy-mm-dd',
            uiLibrary: 'bootstrap4',
            maxDate: function() {
                return $('#endDate').val();
            }
        });

        $('#endDate').datepicker({
            locale: 'es-es',
            format: 'yyyy-mm-dd',
            uiLibrary: 'bootstrap4',
            minDate: function() {
                return $('#startDate').val();
            }
        });
    </script>
@stop
