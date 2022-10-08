<div>
    <div class="row">
        <div class="form-group col-12 col-sm-9">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>
                <input type="text"
                    class="form-control"
                    wire:model.debounce.500ms='search'
                    placeholder="Buscar por nombre, referencia, capacidad total...">
            </div>
        </div>
        <div class="form-group col-6 col-sm-2">
            <select wire:model="perPage" class="form-control" id="perPage">
                <option>10</option>
                <option>20</option>
                <option>50</option>
                <option>100</option>
            </select>
        </div>
        <div class="form-group col-6 col-sm-1">
            <button type="button" wire:click='clear' class="btn btn-default btn-block">Limpiar</button>
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
                            wire:click="sortBy('reference')"
                            :direction="$sortField === 'reference' ? $sortDirection : null"
                            width="20%">
                            Referencia</x-table.heading>
                        <x-table.heading
                            sortable
                            wire:click="sortBy('total_capacity')"
                            :direction="$sortField === 'total_capacity' ? $sortDirection : null"
                            width="15%">
                            Capacidad total</x-table.heading>
                        <x-table.heading width="15%">Capacidad actual</x-table.heading>
                        <x-table.heading width="10%">Porcentaje</x-table.heading>
                        <x-table.heading width="10%"><i class="fas fa-cogs"></i></x-table.heading>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($projects as $project)
                    <tr>
                        <td>{{ $project->name }}</td>
                        <td>{{ $project->reference }}</td>
                        <td>{{ $project->total_capacity }} L</td>
                        <td>{{ $project->actual_capacity }} L</td>
                        <td>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-green" role="progressbar"
                                    aria-volumenow="{{ $project->percentage }}" aria-volumemin="0" aria-volumemax="100"
                                    style="width: {{ $project->percentage }}%">
                                </div>
                            </div>
                            <small>
                                {{ $project->percentage }}%
                            </small>
                        </td>
                        <td class="text-right">
                            <a href="{{ route('projects.edit', $project) }}" class="btn btn-xs btn-default"><i
                                    class="fas fa-edit mr-2"></i>Editar</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">No existen resultados para la búsqueda realizada.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $projects->links() }}
        </div>
    </div>
</div>
