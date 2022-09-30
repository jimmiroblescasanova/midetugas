<div>
    <input type="text" wire:model.debounce.300ms='query' id="" class="form-control"
        placeholder="Buscar un cliente...">

    @if (strlen($query) >= 3)
        <div class="list-group position-absolute">
            @foreach ($clients as $client)
                <a
                href="{{ route('payments.create', $client['id']) }}"
                class="list-group-item list-group-item-action"
                >{{ $client['name'] }} ({{ $client['line_3'] }})
                </a>
            @endforeach
        </div>
    @endif

</div>
