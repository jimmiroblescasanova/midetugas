<?php

namespace App\Http\Livewire\Tables;

use App\Tank;
use Livewire\Component;
use App\Traits\WithSorting;
use App\Traits\WithSearching;

class Tanks extends Component
{
    use WithSorting;
    use WithSearching;

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function mount()
    {
        $this->sortField = 'brand';
    }

    public function render()
    {
        return view('livewire.tables.tanks', [
            'tanks' => Tank::search($this->search)
                        ->orderBy($this->sortField, $this->sortDirection)
                        ->paginate($this->perPage),
        ]);
    }
}
