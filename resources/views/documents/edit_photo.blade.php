@extends('layouts.main')

@section('title', 'Editar imagen del medidor')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Editar imagen del medidor</div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('documents.updatePhoto', $document) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="photo">Selecciona una nueva imagen</label>
                        <input type="file" name="photo" id="photo" class="form-control" required accept="image/*">
                    </div>
                    <div class="form-group text-center mt-3">
                        <button type="submit" class="btn btn-primary">Actualizar imagen</button>
                        <a href="{{ route('documents.show', $document) }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
                <div class="mt-4 text-center">
                    <img src="{{ asset('storage/' . $document->photo) }}" alt="Imagen actual" class="img-fluid rounded" style="max-height: 300px;">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

