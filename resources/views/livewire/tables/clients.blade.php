<div>
    <div class="row">
        <div class="form-group col-12 col-sm-7">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>
                <input type="text"
                wire:model.debounce.500ms='search'
                class="form-control"
                placeholder="Buscar por nombre, nombre corto, departamento, referencia...">
            </div>
        </div>
        <div class="form-group col-12 col-sm-3" wire:ignore>
            <select class="form-control select2bs4" name="project" id="projectDropdown">
                <option value="all">--Todos los condominios--</option>
                @foreach ($projects as $id => $project)
                <option value="{{ $id }}">{{ $project }}</option>
                @endforeach
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
                            wire:click="sortBy('name')"
                            :direction="$sortField === 'name' ? $sortDirection : null">
                            Nombre</x-table.heading>
                        <x-table.heading
                            sortable
                            width="20%"
                            wire:click="sortBy('shortName')"
                            :direction="$sortField === 'shortName' ? $sortDirection : null">
                            Nombre Corto</x-table.heading>
                        <x-table.heading
                            sortable
                            width="20%"
                            wire:click="sortBy('line_3')"
                            :direction="$sortField === 'line_3' ? $sortDirection : null">
                            Departamento</x-table.heading>
                        <x-table.heading
                            sortable
                            width="15%"
                            wire:click="sortBy('reference')"
                            :direction="$sortField === 'reference' ? $sortDirection : null">
                            Referencia</x-table.heading>
                        <x-table.heading width="15%"><i class="fas fa-cogs"></i></x-table.heading>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($clientes as $cliente)
                    <tr>
                        <td>{{ $cliente->name }}</td>
                        <td>{{ $cliente->shortName }}</td>
                        <td>{{ $cliente->line_3 }}</td>
                        <td>{{ $cliente->reference }}</td>
                        <td class="text-right">
                            <a href="{{ route('clients.show', $cliente) }}" class="btn btn-xs btn-default">
                                <i class="fas fa-eye mr-2"></i>Ver / Editar</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">No existen resultados para la búsqueda realizada.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $clientes->links() }}
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
