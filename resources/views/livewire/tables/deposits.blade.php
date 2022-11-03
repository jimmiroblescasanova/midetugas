<div>
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <x-table.heading
                            sortable
                            width="10%"
                            wire:click="sortBy('id')"
                            :direction="$sortField === 'id' ? $sortDirection : null">
                            Folio
                        </x-table.heading>
                        <x-table.heading
                            sortable
                            width="10%"
                            wire:click="sortBy('date')"
                            :direction="$sortField === 'date' ? $sortDirection : null">
                            Fecha
                        </x-table.heading>
                        <x-table.heading
                            sortable
                            wire:click="sortBy('name')"
                            :direction="$sortField === 'name' ? $sortDirection : null">
                            Nombre del cliente
                        </x-table.heading>
                        <x-table.heading width="10%">Tipo</x-table.heading>
                        <x-table.heading width="10%">Total</x-table.heading>
                        <x-table.heading width="15%">Imprimir</x-table.heading>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($deposits as $deposit)
                        <tr>
                            <td>{{ $deposit->id }}</td>
                            <td>{{ $deposit->date->format('d/m/Y') }}</td>
                            <td>{{ $deposit->client->name }}</td>
                            <td>
                                <span @class([
                                    'badge', 
                                    'badge-pill', 
                                    'badge-primary' => $deposit->type == 'Comercial',
                                    'badge-success' => $deposit->type == 'Doméstico',
                                ])>{{ $deposit->type }}</span>
                            </td>
                            <td>{{ contabilidad($deposit->total) }}</td>
                            <td>
                                <a href="{{ route('deposits.show', $deposit) }}" class="btn btn-default btn-xs" target="_blank">
                                    <i class="fas fa-print mr-2"></i>Imprimir
                                </a>
                                @if ($deposit->active)
                                    <a href="{{ route('deposits.cancel', $deposit) }}" class="btn btn-danger btn-xs mr-2">
                                        <i class="fas fa-ban mr-2"></i>Cancelar
                                    </a>
                                @endif
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
            {{ $deposits->links() }}
        </div>
    </div>
</div>
