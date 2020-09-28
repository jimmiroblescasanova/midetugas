@component('mail::message')
# Email de prueba

Este es un correo de prueba para su servicio de gas.
Si recibió este correo en su bandeja de No deseados (SPAM), puede moverlo a su bandeja de entrada para futuros mensajes.

{{--@component('mail::button', ['url' => ''])
Button Text
@endcomponent--}}

Gracias,<br>
{{ config('app.name') }}
@endcomponent
