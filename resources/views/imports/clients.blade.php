<!-- Modal -->
<div class="modal fade" id="importarClientesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Importar clientes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form wire:submit.prevent='importClients'>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Seleccionar archivo (.csv)</label>
                        <input type="file" wire:model='file' class="form-control-file" id="file">
                        @error('file') <span class="error">{{ $message }}</span> @enderror
                        <small class="form-text text-muted">
                            Click <a href="{{ asset('/imports/clientes.csv') }}">AQUI</a> para descargar plantilla
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" wire:loading.attr="disabled" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" wire:loading.attr="disabled" class="btn btn-primary">
                        <span wire:loading.remove>Importar</span>
                        <span wire:loading wire:target='importClients'><i class="fas fa-spinner fa-spin mr-2"></i>Subiendo espere...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
