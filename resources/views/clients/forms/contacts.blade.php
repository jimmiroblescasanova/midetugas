<div class="row">
    <div class="col-md-7">
        <div class="form-group">
            <label for="ref1_name">Contacto 1: Nombre</label>
            <input type="text"
                   class="form-control {{ $errors->first('ref1_name') ? 'is-invalid' : '' }}"
                   name="ref1_name"
                   id="ref1_name"
                   placeholder="Nombre completo"
                   @cannot('edit_contacts') readonly @endcannot
                   value="{{ old('ref1_name', $client->ref1_name) }}">
            {!! $errors->first('ref1_name', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-md-5">
        <div class="form-group">
            <label for="ref1_phone">Teléfono</label>
            <input type="text"
                   class="form-control {{ $errors->first('ref1_phone') ? 'is-invalid' : '' }}"
                   name="ref1_phone"
                   id="ref1_phone"
                   placeholder="Número de cuenta"
                   @cannot('edit_contacts') readonly @endcannot
                   value="{{ old('ref1_phone', $client->ref1_phone) }}">
            {!! $errors->first('ref1_phone', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-7">
        <div class="form-group">
            <label for="ref2_name">Contacto 2: Nombre</label>
            <input type="text"
                   class="form-control {{ $errors->first('ref2_name') ? 'is-invalid' : '' }}"
                   name="ref2_name"
                   id="ref2_name"
                   placeholder="Nombre completo"
                   @cannot('edit_contacts') readonly @endcannot
                   value="{{ old('ref2_name', $client->ref2_name) }}">
            {!! $errors->first('ref2_name', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-md-5">
        <div class="form-group">
            <label for="ref2_phone">Teléfono</label>
            <input type="text"
                   class="form-control {{ $errors->first('ref2_phone') ? 'is-invalid' : '' }}"
                   name="ref2_phone"
                   id="ref2_phone"
                   placeholder="Número de cuenta"
                   @cannot('edit_contacts') readonly @endcannot
                   value="{{ old('ref2_phone', $client->ref2_phone) }}">
            {!! $errors->first('ref2_phone', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
</div>
