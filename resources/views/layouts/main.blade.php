<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name') }} | @yield('title', 'WebApp')</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('/vendor/adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('/vendor/adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="{{ asset('/vendor/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ asset('/vendor/adminlte/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/vendor/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
    @livewireStyles
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
                        @yield('header')
                    </div>

                    @yield('alert')
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 3.0
            </div>
            <strong>Copyright &copy; {{ NOW()->format('Y') }} <a href="{{ config('app.url') }}">{{ config('app.name') }}</a>.</strong>
            Todos los derechos reservados.
            <small class="text-muted">by <a href="http://jrctecnologia.mx" target="_blank">Jimmi Robles</a></small>
        </footer>

        @yield('modal-section')
    </div>
    <!-- ./wrapper -->
    <form action="{{ route('logout') }}" method="POST" id="logoutForm" class="d-none">
        @csrf
    </form>
    @include('sweetalert::alert')
    <script src="{{ asset('/js/app.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('/vendor/adminlte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    {{-- @include('sweetalert::alert') --}}
    <!-- DataTables -->
    <script src="{{ asset('/vendor/adminlte/plugins/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('/vendor/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('/vendor/adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js"></script>
    <script src="https://unpkg.com/gijgo@1.9.13/js/messages/messages.es-es.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/min/moment-with-locales.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    @livewireScripts
    <script>
        $('#logoutButton').on('click', function(event) {
            event.preventDefault();
            $('#logoutForm').submit();
        });
        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4',
        });
        // funcion para convertir txtbox a money
        $("input[data-type='currency']").on({
            keyup: function() {
                formatCurrency($(this));
            },
            blur: function() { 
                formatCurrency($(this), "blur");
            }
        });
        function formatNumber(n) {
        // format number 1000000 to 1,234,567
        return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, "")
        }

        function formatCurrency(input, blur) {
        // appends $ to value, validates decimal side
        // and puts cursor back in right position.
        
        // get input value
        var input_val = input.val();
        
        // don't validate empty input
        if (input_val === "") { return; }
        
        // original length
        var original_len = input_val.length;

        // initial caret position 
        var caret_pos = input.prop("selectionStart");
            
        // check for decimal
        if (input_val.indexOf(".") >= 0) {

            // get position of first decimal
            // this prevents multiple decimals from
            // being entered
            var decimal_pos = input_val.indexOf(".");

            // split number by decimal point
            var left_side = input_val.substring(0, decimal_pos);
            var right_side = input_val.substring(decimal_pos);

            // add commas to left side of number
            left_side = formatNumber(left_side);

            // validate right side
            right_side = formatNumber(right_side);
            
            // On blur make sure 2 numbers after decimal
            if (blur === "blur") {
            right_side += "00";
            }
            
            // Limit decimal to only 2 digits
            right_side = right_side.substring(0, 2);

            // join number by .
            input_val = left_side + "." + right_side;

        } else {
            // no decimal entered
            // add commas to number
            // remove all non-digits
            input_val = formatNumber(input_val);
            // input_val = "$" + input_val;
            
            // final formatting
            if (blur === "blur") {
            input_val += ".00";
            }
        }
        
        // send updated string to input
        input.val(input_val);

        // put caret back in the right position
        var updated_len = input_val.length;
        caret_pos = updated_len - original_len + caret_pos;
        input[0].setSelectionRange(caret_pos, caret_pos);
        }
    </script>
    @yield('scripts')
    @stack('lw-scripts')
</body>

</html>
