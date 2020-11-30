@extends('layouts.main')

@section('header')
    <div class="col-sm-6">
        <h1><i class="fas fa-boxes"></i> Inventarios</h1>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('inventories.store') }}" role="form" method="POST">
                        @csrf
                        <input type="hidden" name="user" value="{{ auth()->user()->name }}">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="date">Fecha</label>
                                    <input type="text"
                                           class="form-control datepicker {{ $errors->first('date') ? 'is-invalid' : '' }}"
                                           name="date"
                                           id="date"
                                           value="{{ old('date') }}">
                                    {!! $errors->first('date', '<div class="invalid-feedback">:message</div>') !!}
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="project_id">Condominio</label>
                                    <select class="form-control select2bs4 {{ $errors->first('project_id') ? 'is-invalid' : '' }}"
                                            name="project_id"
                                            id="project_id"
                                            data-placeholder="Selecciona una opción">
                                        <option></option>
                                        @foreach ($projects as $id => $project)
                                            <option value="{{ $id }}">{{ $project }}</option>
                                        @endforeach
                                    </select>
                                    {!! $errors->first('project_id', '<div class="invalid-feedback">:message</div>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="tank_id">Tanque</label>
                                    <select class="form-control select2bs4 {{ $errors->first('tank_id') ? 'is-invalid' : '' }}"
                                            name="tank_id"
                                            id="tank_id">
                                        <option></option>
                                    </select>
                                    {!! $errors->first('tank_id', '<div class="invalid-feedback">:message</div>') !!}
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="quantity">Cantidad (m<sup>3</sup>)</label>
                                    <input type="text"
                                           class="form-control {{ $errors->first('quantity') ? 'is-invalid' : '' }}"
                                           name="quantity"
                                           id="quantity" value="{{ old('quantity') }}">
                                    {!! $errors->first('quantity', '<div class="invalid-feedback">:message</div>') !!}
                                </div>
                            </div>
                        </div>
                            <button type="submit" class="btn btn-primary">Enviar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let today, datepicker;
        today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
        datepicker = $('.datepicker').datepicker({
            minDate: today,
            locale: 'es-es',
            format: 'yyyy-mm-dd',
            uiLibrary: 'bootstrap4',
        });

        $(document).ready(function() {
            $('#project_id').on('change', function(e){
                // let id = $( "#project_id option:selected" ).val();
                let id = e.target.value;
                console.log(id);

                $.ajax({

                    url:"{{ route('inventories.fillTanks') }}",
                    type:"POST",
                    data: {
                        project_id: id
                    },
                    success:function (data) {
                        $('#tank_id').empty();
                        // console.log(data);
                        console.log(data.tanks);
                        $.each(data.tanks, function(index, tank){
                            // console.log(tank.serial_number);
                            $('#tank_id').append('<option value="'+tank.id+'">'+tank.model + ' - ' + tank.serial_number+'</option>');
                        });

                    }
                });
            });
        });
    </script>
@stop
