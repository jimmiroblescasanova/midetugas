<div>
    <div class="row">
        <div class="form-group col-12 col-sm-7">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>
                <input type="text" class="form-control" wire:model.debounce.500ms='search'
                    placeholder="Buscar por marca, modelo, número de serie, medida actual...">
            </div>
        </div>
        <div class="form-group col-4 col-sm-2">
            <select wire:model='status' class="form-control">
                <option value="all">--- Todos ---</option>
                <option value="1">Activo</option>
                <option value="0">Inactivo</option>
            </select>
        </div>
        <div class="form-group col-4 col-sm-2">
            <select wire:model="perPage" class="form-control" id="perPage">
                <option>10</option>
                <option>20</option>
                <option>50</option>
                <option>100</option>
            </select>
        </div>
        <div class="form-group col-4 col-sm-1">
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
                            wire:click="sortBy('brand')"
                            :direction="$sortField === 'brand' ? $sortDirection : null">
                            Marca
                        </x-table.heading>
                        <x-table.heading
                            sortable
                            width="20%"
                            wire:click="sortBy('model')"
                            :direction="$sortField === 'model' ? $sortDirection : null">
                            Modelo
                        </x-table.heading>
                        <x-table.heading
                            sortable
                            width="15%"
                            wire:click="sortBy('serial_number')"
                            :direction="$sortField === 'serial_number' ? $sortDirection : null">
                            Núm. de serie
                        </x-table.heading>
                        <x-table.heading width="15%">Medida actual</x-table.heading>
                        <x-table.heading width="10%">Factor</x-table.heading>
                        <x-table.heading width="10%">Estado</x-table.heading>
                        <x-table.heading width="10%"><i class="fas fa-cogs"></i></x-table.heading>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($medidores as $medidor)
                    <tr>
                        <td>{{ $medidor->brand }}</td>
                        <td>{{ $medidor->model }}</td>
                        <td>{{ $medidor->serial_number }}</td>
                        <td>{{ $medidor->actual_measure }} m<sup>3</sup></td>
                        <td>{{ $medidor->correction_factor }}</td>
                        <td>{!! setBadge($medidor->active) !!}</td>
                        <td class="text-right">
                            <a href="{{ route('measurers.edit', $medidor) }}" class="btn btn-default btn-xs">
                                <i class="fas fa-edit mr-2"></i>Editar</a>
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
            {{ $medidores->links() }}
        </div>
    </div>
</div>
