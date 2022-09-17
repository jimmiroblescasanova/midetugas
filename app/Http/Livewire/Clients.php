<?php

namespace App\Http\Livewire;

use App\Client;
use Livewire\Component;
use Livewire\WithPagination;

class Clients extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search = "";
    public $perPage = 10;
    public $orderColumn = 'id';
    public $orientation = 'asc';

    public function clear()
    {
        $this->reset([
            'search',
            'perPage',
            'orderColumn',
            'orientation'
        ]);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {

        return view('livewire.clients', [
            'clientes' => Client::searchClient($this->search)
                ->orderBy($this->orderColumn, $this->orientation)
                ->paginate($this->perPage),
        ]);
    }
}
