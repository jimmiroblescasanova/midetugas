@props(['name'])

@error($name)
    <span {{ $attributes->merge(['class' => 'invalid-feedback d-block']) }} role="alert">
        <strong>{{ $message }}</strong>
    </span>
@enderror
