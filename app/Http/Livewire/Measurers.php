<?php

namespace App\Http\Livewire;

use App\Measurer;
use Livewire\Component;
use Livewire\WithPagination;

class Measurers extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search = "";
    public $orderColumn = "brand";
    public $orientation = "asc";
    public $perPage = 10;
    public $status = 1;

    public function clear()
    {
        $this->reset([
            'search', 'orderColumn', 'orientation', 'perPage', 'status'
        ]);
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.measurers', [
            'medidores' => Measurer::searchMeasurer($this->search)
                ->where('active', $this->status)
                ->orderBy($this->orderColumn, $this->orientation)
                ->paginate($this->perPage),
        ]);
    }
}
