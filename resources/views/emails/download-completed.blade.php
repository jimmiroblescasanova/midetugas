@component('mail::message')
# Midetugas

Ya puedes descargar tu archivo en el boton de abajo.

@component('mail::button', ['url' => url("download/{$link}")])
    Descargar
@endcomponent

Saludos,<br>
{{ config('app.name') }}
@endcomponent
