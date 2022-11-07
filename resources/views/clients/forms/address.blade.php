<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="line_1">Calle y número</label>
            <input type="text" class="form-control {{ $errors->first('line_1') ? 'is-invalid' : '' }}" name="line_1"
                id="line_1" placeholder="Calle" value="{{ old('line_1', $client->line_1) }}">
            {!! $errors->first('line_1', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="line_2">Edificio</label>
            <input type="text" class="form-control {{ $errors->first('line_2') ? 'is-invalid' : '' }}" name="line_2"
                id="line_2" placeholder="Edificio" value="{{ old('line_2', $client->line_2) }}">
            {!! $errors->first('line_2', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="line_3">Departamento</label>
            <input type="text" class="form-control {{ $errors->first('line_3') ? 'is-invalid' : '' }}" name="line_3"
                id="line_3" placeholder="Departamento" value="{{ old('line_3', $client->line_3) }}">
            {!! $errors->first('line_3', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="locality">Colonia</label>
            <input type="text" class="form-control {{ $errors->first('locality') ? 'is-invalid' : '' }}"
                name="locality" id="locality" placeholder="Colonia" value="{{ old('locality', $client->locality) }}">
            {!! $errors->first('locality', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="city">Ciudad</label>
            <input type="text" class="form-control {{ $errors->first('city') ? 'is-invalid' : '' }}" name="city"
                id="city" placeholder="Ciudad" value="{{ old('city', $client->city) }}">
            {!! $errors->first('city', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="country">País</label>
            <select class="form-control select2bs4" id="country" name="country" data-placeholder="Seleccionar una opción...">
                <option></option>
                <option value="México" id="MX">México</option>
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="state_province">Estado</label>
            <select class="form-control select2bs4" id="state_province" name="state_province" data-placeholder="Selecciona un estado...">
                <option></option>
                <optgroup label="Más comunes">
                    <option value="Quintana Roo">Quintana Roo</option>
                </optgroup>
                <optgroup label="Otras opciones">
                    <option value="Aguascalientes">Aguascalientes</option>
                    <option value="Baja California">Baja California</option>
                    <option value="Baja California Sur">Baja California Sur</option>
                    <option value="Campeche">Campeche</option>
                    <option value="Chiapas">Chiapas</option>
                    <option value="Chihuahua">Chihuahua</option>
                    <option value="Coahuila">Coahuila</option>
                    <option value="Colima">Colima</option>
                    <option value="Distrito Federal">Distrito Federal</option>
                    <option value="Durango">Durango</option>
                    <option value="Estado de México">Estado de México</option>
                    <option value="Guanajuato">Guanajuato</option>
                    <option value="Guerrero">Guerrero</option>
                    <option value="Hidalgo">Hidalgo</option>
                    <option value="Jalisco">Jalisco</option>
                    <option value="Michoacán">Michoacán</option>
                    <option value="Morelos">Morelos</option>
                    <option value="Nayarit">Nayarit</option>
                    <option value="Nuevo León">Nuevo León</option>
                    <option value="Oaxaca">Oaxaca</option>
                    <option value="Puebla">Puebla</option>
                    <option value="Querétaro">Querétaro</option>
                    <option value="San Luis Potosí">San Luis Potosí</option>
                    <option value="Sinaloa">Sinaloa</option>
                    <option value="Sonora">Sonora</option>
                    <option value="Tabasco">Tabasco</option>
                    <option value="Tamaulipas">Tamaulipas</option>
                    <option value="Tlaxcala">Tlaxcala</option>
                    <option value="Veracruz">Veracruz</option>
                    <option value="Yucatán">Yucatán</option>
                    <option value="Zacatecas">Zacatecas</option>
                </optgroup>
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="zipcode">Código postal</label>
            <input type="text" class="form-control {{ $errors->first('zipcode') ? 'is-invalid' : '' }}"
                name="zipcode" id="zipcode" placeholder="Código postal"
                value="{{ old('zipcode', $client->zipcode) }}">
            {!! $errors->first('zipcode', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-md-8">
        <div class="form-group">
            <label for='project_id'>Condominio</label>
            <select id='project_id' name='project_id' data-placeholder="Seleccionar condominio"
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
