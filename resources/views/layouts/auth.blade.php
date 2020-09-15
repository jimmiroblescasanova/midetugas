<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name') }} | @yield('title', 'WebApp')</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('/vendor/adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
</head>
<body class="hold-transition login-page">

@if(session()->has('info'))
    @include('partials.alerts.info')
@endif

<div class="login-box">
    @yield('content')
</div>
<!-- /.login-box -->

<!-- AdminLTE App -->
<script src="{{ asset('/js/app.js') }}"></script>

</body>
</html>

