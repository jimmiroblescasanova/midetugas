@props([
    'sortable' => null,
    'direction' => null,
])

<th {{ $attributes->merge(['class' => 'text-center']) }}>
    @unless ($sortable)
        {{ $slot }}
    @else
        <a style="cursor: pointer;">
            @if ($direction === 'asc')
                <i class="fas fa-sort-alpha-down mr-2"></i>
            @elseif($direction === 'desc')
                <i class="fas fa-sort-alpha-down-alt mr-2"></i>
            @else
                <i class="fas fa-sort text-muted mr-2"></i>
            @endif
            {{ $slot }}
        </a>
    @endif
</th>
