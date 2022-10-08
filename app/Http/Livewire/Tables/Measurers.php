<?php

namespace App\Http\Livewire\Tables;

use App\Measurer;
use Livewire\Component;
use App\Traits\WithSorting;
use App\Traits\WithSearching;

class Measurers extends Component
{
    use WithSorting;
    use WithSearching;

    public $status = 'all';

    public function clear()
    {
        $this->reset([
            'search',
            'perPage',
            'status',
        ]);
        $this->resetPage();
    }

    public function mount()
    {
        $this->sortField = 'brand';
    }

    public function render()
    {
        return view('livewire.tables.measurers', [
            'medidores' => Measurer::search($this->search)
                    ->when($this->status != 'all', function($q) {
                        $q->where('active', $this->status);
                    })
                    ->orderBy($this->sortField, $this->sortDirection)
                    ->paginate($this->perPage),
        ]);
    }
}
