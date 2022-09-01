<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="brand">Marca</label>
            <input type="text" class="form-control {{ $errors->first('brand') ? 'is-invalid' : '' }}" name="brand"
                id="brand" placeholder="Marca" value="{{ old('brand', $measurer->brand) }}">
            {!! $errors->first('brand', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="model">Modelo</label>
            <input type="text" class="form-control {{ $errors->first('model') ? 'is-invalid' : '' }}" name="model"
                id="model" placeholder="Modelo" value="{{ old('model', $measurer->model) }}">
            {!! $errors->first('model', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="serial_number">Número de serie</label>
            <input type="text" class="form-control {{ $errors->first('serial_number') ? 'is-invalid' : '' }}"
                name="serial_number" id="serial_number" placeholder="Número de serie"
                value="{{ old('serial_number', $measurer->serial_number) }}">
            {!! $errors->first('serial_number', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="correction_factor">Factor de corrección:</label>
            <select class="form-control" name="correction_factor" id="correction_factor">
                {{-- <option value="1.17" {{ ($measurer->correction_factor == '1.17') ? 'selected' : '' }}>2.5 PSI</option> --}}
                @foreach ($factors as $factor)
                    <option value="{{ $factor->value }}"
                        {{ $measurer->correction_factor == $factor->value ? 'selected' : '' }}>{{ $factor->psig }} PSI
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>
