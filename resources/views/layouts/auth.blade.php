<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} | @yield('title', 'Acceso')</title>

    @filamentStyles
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen bg-gray-100 text-gray-950 antialiased">
    <main class="flex min-h-screen items-center justify-center px-4 py-10">
        <div class="w-full max-w-md rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-200">
            @yield('content')
        </div>
    </main>

    @filamentScripts
    @vite('resources/js/app.js')
</body>
</html>
