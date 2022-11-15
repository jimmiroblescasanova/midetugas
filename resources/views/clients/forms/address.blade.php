<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="line_1">Calle y número</label>
            <input 
                type="text" 
                class="form-control {{ $errors->first('line_1') ? 'is-invalid' : '' }}" 
                name="line_1"
                id="line_1" 
                placeholder="Calle" 
                @cannot('edit_addresses') readonly @endcannot
                value="{{ old('line_1', $client->line_1) }}">
            {!! $errors->first('line_1', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="line_2">Edificio</label>
            <input 
                type="text" 
                class="form-control {{ $errors->first('line_2') ? 'is-invalid' : '' }}" 
                name="line_2"
                id="line_2" 
                placeholder="Edificio" 
                @cannot('edit_addresses') readonly @endcannot
                value="{{ old('line_2', $client->line_2) }}">
            {!! $errors->first('line_2', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="line_3">Departamento</label>
            <input 
                type="text" 
                class="form-control {{ $errors->first('line_3') ? 'is-invalid' : '' }}" 
                name="line_3"
                id="line_3" 
                placeholder="Departamento" 
                @cannot('edit_addresses') readonly @endcannot
                value="{{ old('line_3', $client->line_3) }}">
            {!! $errors->first('line_3', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="locality">Colonia</label>
            <input 
                type="text" 
                class="form-control {{ $errors->first('locality') ? 'is-invalid' : '' }}"
                name="locality" 
                id="locality" 
                placeholder="Colonia" 
                @cannot('edit_addresses') readonly @endcannot
                value="{{ old('locality', $client->locality) }}">
            {!! $errors->first('locality', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="city">Ciudad</label>
            <input 
                type="text" 
                class="form-control {{ $errors->first('city') ? 'is-invalid' : '' }}" 
                name="city"
                id="city" 
                placeholder="Ciudad" 
                @cannot('edit_addresses') readonly @endcannot
                value="{{ old('city', $client->city) }}">
            {!! $errors->first('city', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="state_province">Estado</label>
            <input 
                type="text" 
                class="form-control {{ $errors->first('state_province') ? 'is-invalid' : '' }}" 
                name="state_province"
                id="state_province" 
                placeholder="Estado" 
                @cannot('edit_addresses') readonly @endcannot
                value="{{ old('state_province', $client->state_province) }}">
            {!! $errors->first('state_province', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="country">País</label>
            <input 
                type="text" 
                class="form-control {{ $errors->first('country') ? 'is-invalid' : '' }}" 
                name="country"
                id="country" 
                placeholder="País" 
                @cannot('edit_addresses') readonly @endcannot
                value="{{ old('country', $client->country) }}">
            {!! $errors->first('country', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="zipcode">Código postal</label>
            <input 
                type="text" 
                class="form-control {{ $errors->first('zipcode') ? 'is-invalid' : '' }}"
                name="zipcode" 
                id="zipcode" 
                placeholder="Código postal"
                @cannot('edit_addresses') readonly @endcannot
                value="{{ old('zipcode', $client->zipcode) }}">
            {!! $errors->first('zipcode', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-md-8">
        <div class="form-group">
            <label for='project_id'>Condominio</label>
            <select 
                id='project_id' 
                name='project_id' 
                data-placeholder="Seleccionar condominio"
                @cannot('edit_addresses') disabled @endcannot
                class='form-control select2bs4 {{ $errors->first('project_id') ? 'is-invalid' : '' }}'>
                <option value=""></option>
                @foreach ($projects as $id => $project)
                    <option value="{{ $id }}" {{ $id == $client->project_id ? 'selected' : '' }}>
                        {{ $project }}</option>
                @endforeach
            </select>
            {!! $errors->first('project_id', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
</div>
