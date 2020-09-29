@extends('layouts.main')

@section('header')
    <div class="col-sm-6">
        <h1><i class="fas fa-user"></i> Usuarios</h1>
    </div>
    @can('create_users')
        <div class="col-sm-6">
            <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm float-sm-right btn-block-xs-only">
                <i class="fas fa-pencil-alt"></i> Crear nuevo</a>
        </div>
    @endcan
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            @can('edit_users')
                                <th>Acciones</th>
                            @endcan
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                @can('edit_users')
                                    <td class="text-right">
                                        <a href="{{ route('users.edit', $user) }}" class="btn btn-xs btn-primary"><i class="fas fa-edit"></i> Ver / Editar</a>
                                    </td>
                                @endcan
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')

@stop
