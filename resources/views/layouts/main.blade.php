<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} | @yield('title', 'WebApp')</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('/vendor/adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('/vendor/adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="{{ asset('/vendor/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">

    <link rel="stylesheet" href="{{ asset('/vendor/adminlte/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/vendor/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- overlayScrollbars -->
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
<!-- Site wrapper -->
<div class="wrapper">
    <!-- Navbar -->
@include('partials.navbar')
<!-- /.navbar -->

    <!-- Main Sidebar Container -->
@include('partials.sidebar')

<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>@yield('content-title', 'Efigas')</h1>
                    </div>
                    <div class="col-sm-6">
                        @yield('action-button')
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <section class="content">
            @yield('content')
        </section>
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
            <b>Version</b> 2.0
        </div>
        <strong>Copyright &copy; {{ NOW()->format('Y') }} <a href="{{ config('app.url') }}">Efigas</a>.</strong> Todos los derechos reservados.
        <small class="text-muted">by <a href="http://jimmirobles.tech" target="_blank">Jimmi Robles</a></small>
    </footer>
</div>
<!-- ./wrapper -->
<form action="{{ route('logout') }}" method="POST" id="logoutForm" class="d-none">
    @csrf
</form>
<script src="{{ asset('/js/app.js') }}"></script>
<!-- SweetAlert2 -->
<script src="{{ asset('/vendor/adminlte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
{{--@include('sweetalert::alert')--}}
<!-- DataTables -->
<script src="{{ asset('/vendor/adminlte/plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('/vendor/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<!-- Select2 -->
<script src="{{ asset('/vendor/adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
@yield('scripts')
<script>
    $('#logoutButton').on('click', function (event) {
        event.preventDefault();
        $('#logoutForm').submit();
    });
</script>
</body>
</html>
