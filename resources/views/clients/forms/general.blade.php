<div class="row">
    @if (request()->routeIs('clients.show'))
        <div class="col-md-4">
            <div class="form-group">
                <label for="account_number">Número de cuenta</label>
                <input type="text" class="form-control" id="account_number" value="{{ $client->id }}" readonly />
            </div>
        </div>
    @endif
    <div class="{{ request()->routeIs('clients.show') ? 'col-md-8' : 'col-md-12' }}">
        <div class="form-group">
            <label for="name">Nombre completo</label>
            <input type="text" class="form-control {{ $errors->first('name') ? 'is-invalid' : '' }}" name="name"
                id="name" placeholder="Nombre completo" value="{{ old('name', $client->name) }}" @cannot('edit_clients') readonly @endcannot>
            {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="rfc">RFC</label>
            <input type="text" class="form-control {{ $errors->first('rfc') ? 'is-invalid' : '' }}" name="rfc"
                id="rfc" placeholder="RFC" value="{{ old('rfc', $client->rfc) }}" @cannot('edit_clients') readonly @endcannot>
            {!! $errors->first('rfc', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control {{ $errors->first('email') ? 'is-invalid' : '' }}" name="email"
                id="email" placeholder="Ingresar email" value="{{ old('email', $client->email) }}" @cannot('edit_clients') readonly @endcannot>
            {!! $errors->first('email', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="reference">Referencia de pago</label>
            <input type="text" class="form-control {{ $errors->first('reference') ? 'is-invalid' : '' }}"
                name="reference" id="reference" placeholder="Ingresar referencia de pago (max. 7 caracteres)"
                value="{{ old('reference', $client->reference) }}" @cannot('edit_clients') readonly @endcannot>
            {!! $errors->first('reference', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for='country_code'>Código de País</label>
            <select id='country_code' name='country_code' class='form-control select2bs4' @cannot('edit_clients') disabled @endcannot>
                @include('partials.country-codes')
            </select>
        </div>
    </div>
    <div class="col-md-8">
        <div class="form-group">
            <label for="phone">Teléfono</label>
            <input type="text" class="form-control {{ $errors->first('phone') ? 'is-invalid' : '' }}" name="phone"
                id="phone" placeholder="Número de teléfono (sin guiones ni espacios)"
                value="{{ old('phone', $client->phone) }}" @cannot('edit_clients') readonly @endcannot>
            {!! $errors->first('phone', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="shortName">Nombre corto</label>
            <input type="text" class="form-control {{ $errors->first('shortName') ? 'is-invalid' : '' }}"
                name="shortName" id="shortName" placeholder="Nombre corto"
                value="{{ old('shortName', $client->shortName) }}" @cannot('edit_clients') readonly @endcannot>
            {!! $errors->first('shortName', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for='measurer_id'>Medidor</label>
            <select id='measurer_id' name='measurer_id' data-placeholder="Seleccionar un medidor" class='form-control {{ $errors->first('measurer_id') ? 'is-invalid' : '' }}' required @cannot('edit_clients') disabled @endcannot>
                <option></option>
                @if ($client->measurer()->exists())
                    <option value="{{ $client->measurer->id }}" selected>{{ $client->measurer->serial_number }}</option>
                @endif
                @foreach ($measurers as $measurer)
                    <option value="{{ $measurer->id }}">{{ $measurer->serial_number }}</option>
                @endforeach
            </select>
            {!! $errors->first('measurer_id', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    @can('edit_clients')
        <div class="col-md-2 d-flex align-items-center">
            <div class="form-group">
                <div class="form-check">
                    <input type="checkbox" name="1" id="SinMedidor" class="form-check-input" {{ $client->measurer()->exists() ? '' : 'checked' }}>
                    <label for="SinMedidor" class="form-check-label">Sin medidor</label>
                </div>
            </div>
        </div>  
    @endcan
    
</div>
