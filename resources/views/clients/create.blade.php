@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                            <form action="{{ route('clients.store') }}" role="form" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="code">Número de cuenta</label>
                                            <input type="text" class="form-control {{ $errors->first('account_number') ? 'is-invalid' : '' }}" name="account_number" id="code" placeholder="Número de cuenta">
                                            {!! $errors->first('account_number', '<div class="invalid-feedback">:message</div>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="name">Nombre completo</label>
                                            <input type="name" class="form-control {{ $errors->first('name') ? 'is-invalid' : '' }}" name="name" id="name" placeholder="Nombre completo">
                                            {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="rfc">RFC</label>
                                            <input type="text" class="form-control {{ $errors->first('rfc') ? 'is-invalid' : '' }}" name="rfc" id="rfc" placeholder="RFC">
                                            {!! $errors->first('rfc', '<div class="invalid-feedback">:message</div>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control {{ $errors->first('email') ? 'is-invalid' : '' }}" name="email" id="email" placeholder="Ingresar email">
                                            {!! $errors->first('email', '<div class="invalid-feedback">:message</div>') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="phone">Teléfono</label>
                                            <input type="text" class="form-control {{ $errors->first('phone') ? 'is-invalid' : '' }}" name="phone" id="phone" placeholder="Número de teléfono">
                                            {!! $errors->first('phone', '<div class="invalid-feedback">:message</div>') !!}
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-sm btn-primary" type="submit">Completar</button>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
