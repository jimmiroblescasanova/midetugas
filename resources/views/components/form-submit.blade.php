@props(['label' => null])

<button type="submit" {{ $attributes->merge(['class' => 'btn btn-primary']) }}>
    {{ $label ?? $slot }}
</button>
