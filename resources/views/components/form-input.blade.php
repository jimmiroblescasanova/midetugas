@props([
    'bind' => null,
    'label' => null,
    'name',
    'type' => 'text',
])

@php
    $id = $attributes->get('id', str_replace(['.', '[]'], ['_', ''], $name));
    $value = old($name, data_get($bind, $name));
@endphp

<div class="{{ $type === 'hidden' ? 'd-none' : 'form-group' }}">
    @if($label)
        <label for="{{ $id }}">{{ $label }}</label>
    @endif

    <input
        id="{{ $id }}"
        name="{{ $name }}"
        type="{{ $type }}"
        value="{{ $type === 'password' ? '' : $value }}"
        {{ $attributes->merge(['class' => 'form-control' . ($errors->has($name) ? ' is-invalid' : '')]) }}
    >

    {{ $slot }}

    <x-form-errors :name="$name" />
</div>
