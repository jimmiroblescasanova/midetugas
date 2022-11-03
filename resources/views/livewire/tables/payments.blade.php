<div>
    <div class="row">
        <div class="form-group col-12 col-md-6">
            <input type="text" wire:model.debounce.500ms="search" class="form-control" placeholder="Buscar por nombre, importe">
        </div>
        <div class="form-group col-6 col-md-3">
            <input type="text" id="date-range" class="form-control" placeholder="Selecciona un rango de fechas">
        </div>
        <div class="form-group col-6 col-md-2">
            <select wire:model="perPage" class="form-control">
                <option>10</option>
                <option>15</option>
                <option>20</option>
                <option>30</option>
                <option>50</option>
            </select>
        </div>
        <div class="form-group col-md-1">
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
                            width="10%"
                            wire:click="sortBy('id')"
                            :direction="$sortField === 'id' ? $sortDirection : null">
                            ID
                        </x-table.heading>
                        <x-table.heading 
                            sortable 
                            width="15%"
                            wire:click="sortBy('date')"
                            :direction="$sortField === 'date' ? $sortDirection : null">
                            Fecha de aplicación
                        </x-table.heading>
                        <x-table.heading 
                            sortable 
                            width="15%"
                            wire:click="sortBy('created_at')"
                            :direction="$sortField === 'created_at' ? $sortDirection : null">
                            Fecha de captura</x-table.heading>
                        <x-table.heading 
                            sortable 
                            wire:click="sortBy('name')"
                            :direction="$sortField === 'name' ? $sortDirection : null">
                            Cliente
                        </x-table.heading>
                        <x-table.heading>Importe</x-table.heading>
                        <x-table.heading width="10%">Acción</x-table.heading>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($payments as $pay)
                        <tr>
                            <td>{{ $pay->id }}</td>
                            <td>{{ $pay->date->format('d/m/Y') }}</td>
                            <td>{{ $pay->created_at->format('d/m/Y') }}</td>
                            <td>{{ $pay->client->name }}</td>
                            <td>{{ contabilidad($pay->amount) }}</td>
                            <td>
                                <a href="{{ route('payments.show', $pay) }}" class="btn btn-xs btn-default">
                                    <i class="fas fa-eye mr-2"></i>Ver
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">No existen registros para la búsqueda realizada.</td>
                        </tr>   
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $payments->links() }}
        </div>
    </div>
</div>

@push('lw-scripts')
    <script>
        $('input#date-range').daterangepicker({
            autoUpdateInput: false,
            locale: {
                format: 'DD/MM/YYYY',
                cancelLabel: 'Cancelar',
                applyLabel: 'Aplicar', 
                "daysOfWeek": [
                    "Do",
                    "Lu",
                    "Ma",
                    "Mi",
                    "Ju",
                    "Vi",
                    "Sa"
                ],
                "monthNames": [
                    "Enero",
                    "Febrero",
                    "Marzo",
                    "Abril",
                    "Mayo",
                    "Junio",
                    "Julio",
                    "Agosto",
                    "Septiembre",
                    "Octubre",
                    "Noviembre",
                    "Deciembre"
                ],
            }
        });

        $('input#date-range').on('apply.daterangepicker', function(ev, picker){
            $(this).val('Del ' + picker.startDate.format('DD/MM/YYYY') + ' al ' + picker.endDate.format('DD/MM/YYYY'));
            @this.set('startDate', picker.startDate.format('YYYY-MM-DD'));
            @this.set('endDate', picker.endDate.format('YYYY-MM-DD'));
        });

        Livewire.on('ClearDates', function() {
            $('input#date-range').val("").change();
        });
    </script>
@endpush