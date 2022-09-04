<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="brand-link">
        <img src="{{ asset(config('app.logo')) }}" alt="Midetugas Logo" class="brand-image elevation-3">
        <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            {{-- <div class="image">
                <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div> --}}
            <div class="info">
                <a href="#" class="d-block">Hola, {{ auth()->user()->short_name }}</a>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link {{ setActive('home') }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Inicio</p>
                    </a>
                </li>
                <li
                    class="nav-item has-treeview {{ showMenu('projects.*') . showMenu('tanks.*') . showMenu('measurers.*') . showMenu('clients.*') . showMenu('contacts.*') . showMenu('address.*') }}">
                    <a href="#"
                        class="nav-link {{ setActive('projects.*') . setActive('tanks.*') . setActive('measurers.*') . setActive('clients.*') . setActive('contacts.*') . setActive('address.*') }}">
                        <i class="nav-icon fas fa-database"></i>
                        <p>Catálogos
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('show_projects')
                            <li class="nav-item">
                                <a href="{{ route('projects.index') }}" class="nav-link {{ setActive('projects.*') }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Condominios</p>
                                </a>
                            </li>
                        @endcan
                        @can('show_tanks')
                            <li class="nav-item">
                                <a href="{{ route('tanks.index') }}" class="nav-link {{ setActive('tanks.*') }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Tanques</p>
                                </a>
                            </li>
                        @endcan
                        @can('show_measurers')
                            <li class="nav-item">
                                <a href="{{ route('measurers.index') }}" class="nav-link {{ setActive('measurers.*') }}">
                                    <i class="nav-icon far fa-circle"></i>
                                    <p>Medidores</p>
                                </a>
                            </li>
                        @endcan
                        @can('show_clients')
                            <li class="nav-item">
                                <a href="{{ route('clients.index') }}"
                                    class="nav-link {{ setActive('clients.*') . setActive('contacts.*') . setActive('address.*') }}">
                                    <i class="nav-icon far fa-circle"></i>
                                    <p>Clientes</p>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
                @canany(['show_documents', 'create_documents', 'pay_documents'])
                    <li
                        class="nav-item has-treeview {{ showMenu('documents.*') . showMenu('payments.*') . showMenu('deposits.*') }}">
                        <a href="#"
                            class="nav-link {{ setActive('documents.*') . setActive('payments.*') . setActive('deposits.*') }}">
                            <i class="nav-icon fas fa-receipt"></i>
                            <p>Recibos
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('create_documents')
                                <li class="nav-item">
                                    <a href="{{ route('documents.create') }}"
                                        class="nav-link {{ setActive('documents.create') }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Capturar</p>
                                    </a>
                                </li>
                            @endcan
                            @can('show_documents')
                                <li class="nav-item">
                                    <a href="{{ route('documents.index') }}"
                                        class="nav-link {{ setActive('documents.index') . setActive('documents.show') }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Listado</p>
                                    </a>
                                </li>
                            @endcan
                            @can('pay_documents')
                                <li class="nav-item">
                                    <a href="{{ route('payments.index') }}" class="nav-link {{ setActive('payments.*') }}">
                                        <i class="nav-icon far fa-circle"></i>
                                        <p>Pagos</p>
                                    </a>
                                </li>
                            @endcan
                            <li class="nav-item">
                                <a href="{{ route('deposits.index') }}" class="nav-link {{ setActive('deposits.*') }}">
                                    <i class="nav-icon far fa-circle"></i>
                                    <p>Depósito en garantía</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcanany
                @can('show_inventories')
                    <li class="nav-item">
                        <a href="{{ route('inventories.index') }}" class="nav-link {{ setActive('inventories.*') }}">
                            <i class="nav-icon fas fa-boxes"></i>
                            <p>Inventarios</p>
                        </a>
                    </li>
                @endcan
                @can('show_users')
                    <li class="nav-item">
                        <a href="{{ route('users.index') }}" class="nav-link {{ setActive('users.*') }}">
                            <i class="nav-icon fas fa-users-cog"></i>
                            <p>Usuarios</p>
                        </a>
                    </li>
                @endcan
                <li
                    class="nav-item has-treeview {{ showMenu('report01.*') . showMenu('report02.*') . showMenu('edc.*') }}">
                    <a href="#" class="nav-link {{ setActive('report01.*') . setActive('report02.*') }}">
                        <i class="nav-icon fas fa-funnel-dollar"></i>
                        <p>Reportes
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('report01.parameters') }}"
                                class="nav-link {{ setActive('report01.*') }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Toma de lectura</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('report02.parameters') }}"
                                class="nav-link {{ setActive('report02.*') }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Saldo de clientes</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('edc.parameters') }}" class="nav-link {{ setActive('edc.*') }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Estado de cuenta</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @can('run_tasks')
                    <li class="nav-item has-treeview {{ showMenu('configuration.*') }}">
                        <a href="#" class="nav-link {{ setActive('configuration.*') }}">
                            <i class="nav-icon fas fa-cogs"></i>
                            <p>Configuraciones
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('factors.index') }}" class="nav-link {{ setActive('factors.index') }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Fact. de correccion</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('configuration.tasks') }}"
                                    class="nav-link {{ setActive('configuration.tasks') }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Procesos especiales</p>
                                </a>
                            </li>
                        </ul>
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
