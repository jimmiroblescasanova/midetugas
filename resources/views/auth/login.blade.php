@extends('layouts.auth')

@section('title', 'Administración')

@section('content')
    <div class="login-logo">
        <a href="#"><b>{{ config('app.name') }}</b> Admin</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Por favor, inicia sesión</p>

            <form action="{{ route('login') }}" method="post" novalidate>
                @csrf
                <div class="input-group mb-3">
                    <label for="email" class="sr-only">Correo electrónico</label>
                    <input type="email" id="email"
                        class="form-control {{ $errors->first('email') ? 'is-invalid' : '' }}" name="email"
                        placeholder="Correo electrónico" value="{{ old('email') }}" autofocus>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    {!! $errors->first('email', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="input-group mb-3">
                    <label for="password" class="sr-only">Contraseña:</label>
                    <input type="password" class="form-control {{ $errors->first('password') ? 'is-invalid' : '' }}"
                        id="password" name="password" placeholder="Contraseña">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    {!! $errors->first('password', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="input-group">
                    <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
                </div>
            </form>

            <p class="mb-1 mt-3">
                <a href="{{ route('password.request') }}">Olvidé mi contraseña</a>
            </p>
        </div>
        <!-- /.login-card-body -->
    </div>
@stop
