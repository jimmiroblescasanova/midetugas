<div class="row">
    <div class="col-md-6 col-12">
        <div class="form-group">
            <label for="project_id">Seleccionar condominio</label>
            <select class="form-control select2bs4 {{ $errors->first('brand') ? 'is-invalid' : '' }}" name="project_id"
                id="project_id">
                <option>Selecciona una opción</option>
                @foreach ($projects as $id => $project)
                    <option value="{{ $id }}" {{ $id == $tank->project_id ? 'selected' : '' }}>
                        {{ $project }}</option>
                @endforeach
            </select>
            {!! $errors->first('project_id', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-md-6 col-12">
        <div class="form-group">
            <label for="manufacturing_date">Fecha de fabricación</label>
            <input type="text"
                class="form-control datepicker {{ $errors->first('manufacturing_date') ? 'is-invalid' : '' }}"
                name="manufacturing_date" id="manufacturing_date"
                value="{{ old('manufacturing_date', is_null($tank->manufacturing_date) ? '' : $tank->manufacturing_date->format('Y-m-d')) }}">
            {!! $errors->first('manufacturing_date', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label for="brand">Marca</label>
            <input type="text" class="form-control {{ $errors->first('brand') ? 'is-invalid' : '' }}" name="brand"
                id="brand" value="{{ old('brand', $tank->brand) }}">
            {!! $errors->first('brand', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label for="model">Modelo</label>
            <input type="text" class="form-control {{ $errors->first('model') ? 'is-invalid' : '' }}" name="model"
                id="model" value="{{ old('model', $tank->model) }}">
            {!! $errors->first('model', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label for="serial_number">Número de serie</label>
            <input type="text" class="form-control {{ $errors->first('serial_number') ? 'is-invalid' : '' }}"
                name="serial_number" id="serial_number" value="{{ old('serial_number', $tank->serial_number) }}">
            {!! $errors->first('serial_number', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label for="capacity">Capacidad (L)</label>
            <input type="text" class="form-control {{ $errors->first('capacity') ? 'is-invalid' : '' }}"
                name="capacity" id="capacity" value="{{ old('capacity', $tank->capacity) }}">
            {!! $errors->first('capacity', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
</div>
