<?php

namespace App\Http\Livewire\Tables;

use App\Deposit;
use Livewire\Component;
use App\Traits\WithSorting;

class Deposits extends Component
{
    use WithSorting;

    public function mount()
    {
        $this->sortField = 'id';
        $this->sortDirection = 'desc';
    }
    
    public function render()
    {
        $deposits = Deposit::withClientName()
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate();

        return view('livewire.tables.deposits', compact('deposits'));
    }
}
