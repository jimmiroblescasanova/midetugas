<div>
    <div class="row">
        <div class="form-group col-12 col-sm-5">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>
                <input type="text" wire:model.debounce.500ms='search' class="form-control"
                    placeholder="Buscar por id, cliente, periodo, importe...">
            </div>
        </div>
        <div class="form-group col-12 col-sm-3" wire:ignore>
            <select class="form-control select2bs4" name="project" id="projectDropdown">
                <option value="all">--- Todos ---</option>
                @foreach ($projects as $id => $project)
                <option value="{{ $id }}">{{ $project }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-12 col-sm-2">
            <select class="form-control" wire:model="status">
                <option value="all">--- Todos ---</option>
                <option value="1">Pendientes</option>
                <option value="2">Autorizados</option>
                <option value="3">Cancelados</option>
            </select>
        </div>
        <div class="form-group col-1 col-sm-1">
            <select wire:model="perPage" class="form-control">
                <option>10</option>
                <option>15</option>
                <option>25</option>
                <option>50</option>
                <option>100</option>
            </select>
        </div>
        <div class="form-group col-12 col-sm-1">
            <button type="button" wire:click="clear" class="btn btn-default btn-block">Limpiar</button>
        </div>
    </div>
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <x-table.heading
                        sortable
                        width="7%"
                        wire:click="sortBy('documents.id')"
                        :direction="$sortField === 'documents.id' ? $sortDirection : null">ID</x-table.heading>
                        <x-table.heading
                        sortable
                        wire:click="sortBy('name')"
                        :direction="$sortField === 'name' ? $sortDirection : null">Cliente</x-table.heading>
                        <x-table.heading
                        sortable
                        width="13%"
                        wire:click="sortBy('name')"
                        :direction="$sortField === 'name' ? $sortDirection : null">Departamento</x-table.heading>
                        <x-table.heading
                        sortable
                        witdh="10%"
                        wire:click="sortBy('documents.period')"
                        :direction="$sortField === 'documents.period' ? $sortDirection : null">Periodo</x-table.heading>
                        <x-table.heading width="10%">Total</x-table.heading>
                        <x-table.heading width="10%">Pendiente</x-table.heading>
                        <x-table.heading width="10%"><i class="fas fa-tools"></i></x-table.heading>
                    </tr>
                </thead>
                <tbody>
                    @forelse($documents as $document)
                    <tr>
                        <td>{{ $document->id }}</td>
                        <td>{{ $document->client->name }} {!! status($document->status) !!}</td>
                        <td>{{ $document->client->line_3 }}</td>
                        <td>{{ $document->period }}</td>
                        <td class="text-right">{{ contabilidad($document->total) }}</td>
                        <td class="text-right">{{ contabilidad($document->pending) }}</td>
                        <td class="text-right">
                            <a href="{{ route('documents.show', $document) }}" class="btn btn-xs btn-default">
                                <i class="fas fa-eye mr-2"></i>Revisar</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">No existen resultados para la búsqueda realizada.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $documents->links() }}
        </div>
    </div>
</div>

@push('lw-scripts')
<script>
    $('#projectDropdown').on('change', function (e) {
        var data = $('select[name=project]').select2("val");
        @this.set('project', data);
    });

    Livewire.on('ClearProject', function() {
        $('select[name=project]').val("all").change();
    });
</script>
@endpush
