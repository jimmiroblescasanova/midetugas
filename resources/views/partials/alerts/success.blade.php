@if (session('message'))
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5><i class="icon fas fa-thumbs-up"></i> Éxito!</h5>
        {{ session('message') }}
    </div>
@endif
