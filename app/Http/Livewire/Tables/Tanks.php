<?php

namespace App\Http\Livewire\Tables;

use App\Tank;
use Livewire\Component;

class Tanks extends Component
{
    public $search = '';
    public $perPage = 10;
    public $sortField = 'brand';
    public $sortDirection = 'desc';

    public function clear()
    {
        $this->reset([
            'search',
            'perPage',
        ]);
    }

    public function sortBy($column)
    {
        if ($this->sortField === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $column;
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
