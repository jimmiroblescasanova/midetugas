@extends('layouts.auth')

@section('title', 'Acceso de clientes')

@section('content')
    <div class="login-logo">
        <a href="#"><b>{{ config('app.name') }}</b> Admin</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-header">Restablecimiento de contraseña</div>

        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
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

                <div class="input-group">
                    <button type="submit" class="btn btn-primary btn-block">Enviar email</button>
                    <button type="button" class="btn btn-default btn-block" onclick="history.back();">Atrás</button>
                </div>
            </form>
        </div>
        <!-- /.login-card-body -->
    </div>
@stop
