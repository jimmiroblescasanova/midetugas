<div>
    <div class="row">
        <div class="form-group col-12 col-sm-9">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>
                <input type="text"
                    class="form-control"
                    wire:model='search'
                    id="search"
                    placeholder="Buscar por marca, modelo, serie, capacidad...">
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
        <div class="card-body p-0 table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <x-table.heading sortable wire:click="sortBy('brand')"
                            :direction="$sortField === 'brand' ? $sortDirection : null">Marca</x-table.heading>
                        <x-table.heading
                            sortable
                            wire:click="sortBy('model')"
                            :direction="$sortField === 'model' ? $sortDirection : null"
                            style="width: 25%;"
                        >Modelo</x-table.heading>
                        <x-table.heading
                            sortable
                            wire:click="sortBy('serial_number')"
                            :direction="$sortField === 'serial_number' ? $sortDirection : null"
                            style="width: 20%;"
                        >Número de serie</x-table.heading>
                        <x-table.heading
                            sortable
                            wire:click="sortBy('capacity')"
                            :direction="$sortField === 'capacity' ? $sortDirection : null"
                            style="width: 20%;"
                        >Capacidad</x-table.heading>
                        <x-table.heading style="width: 10%;">
                            <i class="fas fa-cogs"></i>
                        </x-table.heading>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tanks as $tank)
                    <tr>
                        <td>{{ $tank->brand }}</td>
                        <td>{{ $tank->model }}</td>
                        <td>{{ $tank->serial_number }}</td>
                        <td>{{ $tank->capacity }} L</td>
                        <td class="text-right">
                            <a href="{{ route('tanks.edit', $tank) }}" class="btn btn-xs btn-default">
                                <i class="fas fa-edit mr-2"></i>Editar</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $tanks->links() }}
        </div>
    </div>
</div>
