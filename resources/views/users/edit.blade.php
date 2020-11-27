@extends('layouts.main')

@section('header')
    <div class="col-sm-6">
        <h1><i class="fas fa-user-cog"></i> Editar usuario</h1>
    </div>
    @can('delete_users')
        <div class="col-sm-6">
            <form action="{{ route('users.destroy', $user) }}" method="post">
                @csrf @method('delete')
                <button type="submit" class="btn btn-danger btn-sm float-sm-right btn-block-xs-only">
                    <i class="fas fa-trash"></i> Eliminar</button>
            </form>
        </div>
    @endcan
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <!-- Custom Tabs -->
            <div class="card">
                <div class="card-header d-flex p-0">
                    <h3 class="card-title p-3">Tabs</h3>
                    <ul class="nav nav-pills ml-auto p-2">
                        <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Datos
                                generales</a></li>
                        <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Permisos</a></li>
                    </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <form action="{{ route('users.patch', $user) }}" role="form" method="POST">
                                @csrf @method('patch')
                                @include('users._form')
                                <div class="row">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">Actualizar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="tab_2">
                            <p class="lead">Se deberán marcar / desmarcar las casillas de acuerdo a cada acceso que se quiera otorgar.</p>
                            <form action="{{ route('users.permissions', $user) }}" method="post">
                                @csrf
                                <section>
                                    <hr data-content="Sección de Clientes" class="hr-text">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" name="permissions[]"
                                                   id="show_clients"
                                                   value="show_clients" {{ (in_array('show_clients', $permissions)) ? 'checked' : '' }}>
                                            Ver clientes
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" name="permissions[]"
                                                   id="create_clients"
                                                   value="create_clients" {{ (in_array('create_clients', $permissions)) ? 'checked' : '' }}>
                                            Crear clientes
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" name="permissions[]"
                                                   id="edit_clients"
                                                   value="edit_clients" {{ (in_array('edit_clients', $permissions)) ? 'checked' : '' }}>
                                            Editar clientes
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" name="permissions[]"
                                                   id="edit_contacts"
                                                   value="edit_contacts" {{ (in_array('edit_contacts', $permissions)) ? 'checked' : '' }}>
                                            Editar contactos
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" name="permissions[]"
                                                   id="edit_addresses"
                                                   value="edit_addresses" {{ (in_array('edit_addresses', $permissions)) ? 'checked' : '' }}>
                                            Editar direcciones
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" name="permissions[]"
                                                   id="delete_clients"
                                                   value="delete_clients" {{ (in_array('delete_clients', $permissions)) ? 'checked' : '' }}>
                                            Eliminar clientes
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" name="permissions[]"
                                                   id="change_status"
                                                   value="change_status" {{ (in_array('change_status', $permissions)) ? 'checked' : '' }}>
                                            Cambiar estado del cliente
                                        </label>
                                    </div>
                                </section>
                                <section>
                                    <hr data-content="Sección de Medidores" class="hr-text">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" name="permissions[]"
                                                   id="show_measurers"
                                                   value="show_measurers" {{ (in_array('show_measurers', $permissions)) ? 'checked' : '' }}>
                                            Ver medidores
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" name="permissions[]"
                                                   id="create_measurers"
                                                   value="create_measurers" {{ (in_array('create_measurers', $permissions)) ? 'checked' : '' }}>
                                            Crear medidores
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" name="permissions[]"
                                                   id="edit_measurers"
                                                   value="edit_measurers" {{ (in_array('edit_measurers', $permissions)) ? 'checked' : '' }}>
                                            Editar medidores
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" name="permissions[]"
                                                   id="delete_measurers"
                                                   value="delete_measurers" {{ (in_array('delete_measurers', $permissions)) ? 'checked' : '' }}>
                                            Eliminar medidores
                                        </label>
                                    </div>
                                </section>
                                <section>
                                    <hr data-content="Sección de Documentos" class="hr-text">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" name="permissions[]"
                                                   id="show_documents"
                                                   value="show_documents" {{ (in_array('show_documents', $permissions)) ? 'checked' : '' }}>
                                            Ver documentos
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" name="permissions[]"
                                                   id="create_documents"
                                                   value="create_documents" {{ (in_array('create_documents', $permissions)) ? 'checked' : '' }}>
                                            Crear documentos
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" name="permissions[]"
                                                   id="authorize_documents"
                                                   value="authorize_documents" {{ (in_array('authorize_documents', $permissions)) ? 'checked' : '' }}>
                                            Autorizar documentos
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" name="permissions[]"
                                                   id="cancel_documents"
                                                   value="cancel_documents" {{ (in_array('cancel_documents', $permissions)) ? 'checked' : '' }}>
                                            Cancelar documentos
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" name="permissions[]"
                                                   id="pay_documents"
                                                   value="pay_documents" {{ (in_array('pay_documents', $permissions)) ? 'checked' : '' }}>
                                            Pagar documentos
                                        </label>
                                    </div>
                                </section>
                                <section>
                                    <hr data-content="Sección de Usuarios" class="hr-text">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" name="permissions[]"
                                                   id="show_users"
                                                   value="show_users" {{ (in_array('show_users', $permissions)) ? 'checked' : '' }}>
                                            Ver usuarios
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" name="permissions[]"
                                                   id="create_users"
                                                   value="create_users" {{ (in_array('create_users', $permissions)) ? 'checked' : '' }}>
                                            Crear usuarios
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" name="permissions[]"
                                                   id="edit_users"
                                                   value="edit_users" {{ (in_array('edit_users', $permissions)) ? 'checked' : '' }}>
                                            Editar usuarios
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" name="permissions[]"
                                                   id="delete_users"
                                                   value="delete_users" {{ (in_array('delete_users', $permissions)) ? 'checked' : '' }}>
                                            Eliminar usuarios
                                        </label>
                                    </div>
                                </section>
                                <section>
                                    <hr data-content="Sección de Condominios" class="hr-text">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" name="permissions[]"
                                                   id="show_projects"
                                                   value="show_projects" {{ (in_array('show_projects', $permissions)) ? 'checked' : '' }}>
                                            Ver condominios
                                        </label>
                                    </div><div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" name="permissions[]"
                                                   id="create_projects"
                                                   value="create_projects" {{ (in_array('create_projects', $permissions)) ? 'checked' : '' }}>
                                            Crear condominios
                                        </label>
                                    </div>
                                </section>
                                <section>
                                    <hr data-content="Sección de Tanques" class="hr-text">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" name="permissions[]"
                                                   id="show_tanks"
                                                   value="show_tanks" {{ (in_array('show_tanks', $permissions)) ? 'checked' : '' }}>
                                            Ver tanques
                                        </label>
                                    </div><div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" name="permissions[]"
                                                   id="create_tanks"
                                                   value="create_tanks" {{ (in_array('create_tanks', $permissions)) ? 'checked' : '' }}>
                                            Crear tanques
                                        </label>
                                    </div>
                                </section>
                                <section>
                                    <hr data-content="Sección de Inventarios" class="hr-text">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" name="permissions[]"
                                                   id="show_inventories"
                                                   value="show_inventories" {{ (in_array('show_inventories', $permissions)) ? 'checked' : '' }}>
                                            Ver inventarios
                                        </label>
                                    </div><div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" name="permissions[]"
                                                   id="create_inventories"
                                                   value="create_inventories" {{ (in_array('create_inventories', $permissions)) ? 'checked' : '' }}>
                                            Crear inventario
                                        </label>
                                    </div>
                                </section>
                                <section>
                                    <hr data-content="Sección de Documentos" class="hr-text">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" name="permissions[]"
                                                   id="update_prices"
                                                   value="update_prices" {{ (in_array('update_prices', $permissions)) ? 'checked' : '' }}>
                                            Actualizar precios
                                        </label>
                                    </div>
                                </section>
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-sm btn-primary">Actualizar permisos</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div><!-- /.card-body -->
            </div>
            <!-- ./card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
@stop

@section('scripts')

@stop
