<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text"
                   class="form-control {{ $errors->first('name') ? 'is-invalid' : '' }}"
                   name="name"
                   id="name"
                   placeholder="Nombre completo"
                   value="{{ old('name', $user->name) }}">
            {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email"
                   class="form-control {{ $errors->first('email') ? 'is-invalid' : '' }}"
                   name="email"
                   id="email"
                   placeholder="Correo electrónico"
                   value="{{ old('email', $user->email) }}">
            {!! $errors->first('email', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password"
                   class="form-control {{ $errors->first('password') ? 'is-invalid' : '' }}"
                   name="password"
                   id="password"
                   placeholder="Ingresa la contraseña">
            {!! $errors->first('password', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="password_confirmation">Confirmación</label>
            <input type="password"
                   class="form-control"
                   name="password_confirmation"
                   id="password_confirmation"
                   placeholder="Confirma la contraseña">
        </div>
    </div>
</div>
