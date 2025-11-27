@extends('layouts.main')

@section('title', 'Configuración de Whatsapp')

@section('header')
    <div class="col-sm-6">
        <h1><i class="fas fa-sliders-h mr-2"></i>Configuraciones de la aplicación</h1>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h3>Configuración de Whatsapp</h3>
                    <div>
                        <form action="{{ route('configuration.settings.update-whatsapp-message') }}" method="POST">
                            @csrf
                            <!-- Campo de texto para el mensaje a enviar al cliente -->
                            <div class="form-group">
                                <label for="whatsapp_message">Mensaje para el cliente</label>
                                <input
                                    type="text"
                                    id="whatsapp_message"
                                    name="whatsapp_message"
                                    class="form-control @error('whatsapp_message') is-invalid @enderror"
                                    required
                                    value="{{ old('whatsapp_message', settings()->get('whatsapp_message') ?? '') }}"
                                    placeholder="Escribe aquí el mensaje que se enviará al cliente"
                                >
                                @error('whatsapp_message')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between mt-3">
                                <!-- Botón para guardar configuración -->
                                <button type="submit" class="btn btn-primary">
                                    <i class="fab fa-whatsapp mr-1"></i> Guardar mensaje
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@section('scripts')

@stop
