@props([
    'bind' => null,
    'label' => null,
    'name',
    'options' => null,
    'placeholder' => null,
])

@php
    $id = $attributes->get('id', str_replace(['.', '[]'], ['_', ''], $name));
    $selected = old($name, data_get($bind, $name));
@endphp

<div class="form-group">
    @if($label)
        <label for="{{ $id }}">{{ $label }}</label>
    @endif

    <select
        id="{{ $id }}"
        name="{{ $name }}"
        {{ $attributes->merge(['class' => 'form-control' . ($errors->has($name) ? ' is-invalid' : '')]) }}
    >
        @if($placeholder)
            <option value="">{{ $placeholder }}</option>
        @endif

        @if($options)
            @foreach($options as $value => $text)
                <option value="{{ $value }}" @selected((string) $selected === (string) $value)>{{ $text }}</option>
            @endforeach
        @else
            {{ $slot }}
        @endif
    </select>

    <x-form-errors :name="$name" />
</div>
