<div class="modal fade" id="{{ $id }}" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">¿Estas seguro?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-footer">
                <x-form :action="$action">
                    @method('DELETE')
                    <button type="button" class="btn btn-default" data-dismiss="modal">No, cancelar</button>
                    <button type="submit" class="btn btn-danger">Si, eliminar!</button>
                </x-form>
            </div>
        </div>
    </div>
</div>
