@if (session('alert-message'))
    <div class="alert alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5><i class="icon fas fa-exclamation-triangle"></i>No se pudo crear el recibo</h5>
        {!! session('alert-message') !!}
    </div>
@endif
