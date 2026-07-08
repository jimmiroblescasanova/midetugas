@props([
    'action' => '',
    'method' => 'POST',
])

@php
    $method = strtoupper($method);
    $spoofMethod = ! in_array($method, ['GET', 'POST'], true);
@endphp

<form method="{{ $spoofMethod ? 'POST' : $method }}" action="{{ $action }}" {{ $attributes }}>
    @unless($method === 'GET')
        @csrf
    @endunless

    @if($spoofMethod)
        @method($method)
    @endif

    {{ $slot }}
</form>
