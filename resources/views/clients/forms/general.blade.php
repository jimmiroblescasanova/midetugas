<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="account_number">Número de cuenta</label>
            <input type="text"
                   class="form-control"
                   id="account_number"
                   placeholder="Número de cuenta"
                   value="{{ request()->routeIs('clients.show') ? $client->id : $next_id }}" readonly/>
        </div>
    </div>
    <div class="col-md-8">
        <div class="form-group">
            <label for="name">Nombre completo</label>
            <input type="text"
                   class="form-control {{ $errors->first('name') ? 'is-invalid' : '' }}"
                   name="name"
                   id="name"
                   placeholder="Nombre completo"
                   value="{{ old('name', $client->name) }}">
            {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="rfc">RFC</label>
            <input type="text"
                   class="form-control {{ $errors->first('rfc') ? 'is-invalid' : '' }}"
                   name="rfc"
                   id="rfc"
                   placeholder="RFC"
                   value="{{ old('rfc', $client->rfc) }}">
            {!! $errors->first('rfc', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-md-8">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email"
                   class="form-control {{ $errors->first('email') ? 'is-invalid' : '' }}"
                   name="email"
                   id="email"
                   placeholder="Ingresar email"
                   value="{{ old('email', $client->email) }}">
            {!! $errors->first('email', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for='country_code'>País</label>
            <select id='country_code' name='country_code' class='form-control select2bs4'>
                @include('partials.country-codes')
            </select>
        </div>
    </div>
    <div class="col-md-8">
        <div class="form-group">
            <label for="phone">Teléfono</label>
            <input type="text"
                   class="form-control {{ $errors->first('phone') ? 'is-invalid' : '' }}"
                   name="phone"
                   id="phone"
                   placeholder="Número de teléfono (sin guiones ni espacios)"
                   value="{{ old('phone', $client->phone) }}">
            {!! $errors->first('phone', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
</div>
