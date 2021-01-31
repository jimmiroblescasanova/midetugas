<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="brand">Marca</label>
            <input type="text"
                   class="form-control {{ $errors->first('brand') ? 'is-invalid' : '' }}"
                   name="brand"
                   id="brand"
                   placeholder="Marca"
                   value="{{ old('brand', $measurer->brand) }}">
            {!! $errors->first('brand', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="model">Modelo</label>
            <input type="text"
                   class="form-control {{ $errors->first('model') ? 'is-invalid' : '' }}"
                   name="model"
                   id="model"
                   placeholder="Modelo"
                   value="{{ old('model', $measurer->model) }}">
            {!! $errors->first('model', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="serial_number">Número de serie</label>
            <input type="text"
                   class="form-control {{ $errors->first('serial_number') ? 'is-invalid' : '' }}"
                   name="serial_number"
                   id="serial_number"
                   placeholder="Número de serie"
                   value="{{ old('serial_number', $measurer->serial_number) }}">
            {!! $errors->first('serial_number', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="correction_factor">Factor de corrección:</label>
            <select class="form-control" name="correction_factor" id="correction_factor">
                <option value="1.17" {{ ($measurer->correction_factor == '1.17') ? 'selected' : '' }}>2.5 PSI</option>
                <option value="1.34" {{ ($measurer->correction_factor == '1.34') ? 'selected' : '' }}>5 PSI</option>
                <option value="1.6802" {{ ($measurer->correction_factor == '1.6802') ? 'selected' : '' }}>10 PSI</option>
                <option value="2.0204" {{ ($measurer->correction_factor == '2.0204') ? 'selected' : '' }}>15 PSI</option>
                <option value="2.3606" {{ ($measurer->correction_factor == '2.3606') ? 'selected' : '' }}>20 PSI</option>
                <option value="2.7008" {{ ($measurer->correction_factor == '2.7008') ? 'selected' : '' }}>25 PSI</option>
                <option value="3.0409" {{ ($measurer->correction_factor == '3.0409') ? 'selected' : '' }}>30 PSI</option>
            </select>
        </div>
    </div>
</div>
