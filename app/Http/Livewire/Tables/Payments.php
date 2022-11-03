<?php

namespace App\Http\Livewire\Tables;

use App\Payment;
use Livewire\Component;
use App\Traits\WithSorting;
use App\Traits\WithSearching;

class Payments extends Component
{
    use WithSorting;
    use WithSearching;

    public $startDate = null;
    public $endDate = null;

    public function mount()
    {
        $this->sortField = 'id';
        $this->sortDirection = 'desc';
    }

    public function clear()
    {
        $this->reset([
            'search',
            'perPage',
            'startDate',
            'endDate',
        ]);
        $this->resetPage();
        $this->emit('ClearDates');
    }

    public function render()
    {
        $payments = Payment::withClientName()
            ->search($this->search)
            ->when($this->endDate != null, function ($q) {
                $q->whereBetween('date', [$this->startDate, $this->endDate]);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.tables.payments', compact('payments'));
    }
}
