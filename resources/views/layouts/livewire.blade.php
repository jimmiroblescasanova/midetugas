<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} | @yield('title', 'Panel')</title>

    @filamentStyles
    @vite('resources/css/app.css')
    @livewireStyles
</head>
<body class="min-h-screen bg-gray-50 text-gray-950 antialiased">
    <div class="min-h-screen">
        <header class="border-b border-gray-200 bg-white">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 sm:px-6 lg:px-8">
                <a href="{{ url('/admin') }}" class="text-sm font-semibold text-gray-950">{{ config('app.name') }}</a>
                <a href="{{ url('/admin') }}" class="text-sm text-gray-600 hover:text-gray-950">Panel</a>
            </div>
        </header>

        <main class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            {{ $slot }}
        </main>
    </div>

    @livewireScripts
    @filamentScripts
    @vite('resources/js/app.js')
    @stack('scripts')
</body>
</html>
