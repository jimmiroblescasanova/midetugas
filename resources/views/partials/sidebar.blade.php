<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="brand-link">
        <img src="{{ asset('/logo.png') }}"
             alt="Efigas Logo"
             class="brand-image elevation-3"
             >
        <span class="brand-text font-weight-light">EFIGAS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            {{--<div class="image">
                <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>--}}
            <div class="info">
                <a href="#" class="d-block">Hola, {{ auth()->user()->short_name }}</a>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link {{ setActive('home') }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Inicio</p>
                    </a>
                </li>
                @can('show_clients')
                <li class="nav-item">
                    <a href="{{ route('clients.index') }}" class="nav-link {{ setActive('clients.*') }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Clientes</p>
                    </a>
                </li>
                @endcan
                @can('show_measurers')
                <li class="nav-item">
                    <a href="{{ route('measurers.index') }}" class="nav-link {{ setActive('measurers.*') }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Medidores</p>
                    </a>
                </li>
                @endcan
                @canany(['show_documents', 'create_documents', 'pay_documents'])
                    <li class="nav-item has-treeview {{ showMenu('documents.*') }}">
                        <a href="#" class="nav-link {{ setActive('documents.*') }}">
                            <i class="nav-icon fas fa-receipt"></i>
                            <p>Recibos
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        @can('create_documents')
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('documents.create') }}" class="nav-link {{ setActive('documents.create') }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Capturar</p>
                                    </a>
                                </li>
                            </ul>
                        @endcan
                        @can('show_documents')
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('documents.index') }}" class="nav-link {{ setActive('documents.index') }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Listado</p>
                                    </a>
                                </li>
                            </ul>
                        @endcan
                    </li>
                    @can('pay_documents')
                        <li class="nav-item">
                            <a href="{{ route('payments.index') }}" class="nav-link {{ setActive('payments.*') }}">
                                <i class="nav-icon fas fa-hand-holding-usd"></i>
                                <p>Pagos</p>
                            </a>
                        </li>
                    @endcan
                @endcanany
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-funnel-dollar"></i>
                        <p>Reportes
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Comisiones</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @can('show_users')
                    <li class="nav-item">
                        <a href="{{ route('users.index') }}" class="nav-link {{ setActive('users.*') }}">
                            <i class="nav-icon fas fa-users-cog"></i>
                            <p>Usuarios</p>
                        </a>
                    </li>
                @endcan
                <li class="nav-item">
                    <a href="#" id="logoutButton" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Cerrar sesión</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
