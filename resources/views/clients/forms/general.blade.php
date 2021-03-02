<div class="row">
    @if(request()->routeIs('clients.show'))
        <div class="col-md-4">
            <div class="form-group">
                <label for="account_number">Número de cuenta</label>
                <input type="text"
                       class="form-control"
                       id="account_number"
                       value="{{ $client->id }}" readonly/>
            </div>
        </div>
    @endif
    <div class="{{ request()->routeIs('clients.show') ? 'col-md-8' : 'col-md-12' }}">
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
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for='measurer_id'>Medidor</label>
            <select id='measurer_id'
                    name='measurer_id'
                    data-placeholder="Seleccionar o dejar en blanco"
                    class='form-control select2bs4 {{ $errors->first('measurer_id') ? 'is-invalid' : '' }}'>
                <optgroup label="Medidor actual">
                    @if(isset($actual_measurer))
                            <option value="{{ $actual_measurer->id }}">
                                {{ $actual_measurer->brand }}, {{ $actual_measurer->model }}, {{ $actual_measurer->serial_number }}
                            </option>
                    @else
                        <option value="NULL">Sin medidor</option>
                    @endif
                </optgroup>
                <optgroup label="Medidores disponibles">
                    @foreach($measurers as $measurer)
                        <option value="{{ $measurer->id }}">
                            {{ $measurer->brand }}, {{ $measurer->model }} ({{ $measurer->serial_number }})
                        </option>
                    @endforeach
                </optgroup>
            </select>
            {!! $errors->first('measurer_id', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-md-8">
        <div class="form-group">
            <label for="shortName">Nombre corto</label>
            <input type="text"
                   class="form-control {{ $errors->first('shortName') ? 'is-invalid' : '' }}"
                   name="shortName"
                   id="shortName"
                   placeholder="Nombre corto"
                   value="{{ old('shortName', $client->shortName) }}">
            {!! $errors->first('shortName', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
</div>
