<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Client;

class SearchClients extends Component
{
    public $query;
    public $clients = [];

    public function updatedQuery()
    {
        if (strlen($this->query) >= 3) {
            $this->clients = Client::where('name', 'LIKE', '%' . $this->query . '%')->get()->toArray();
        }
    }

    public function render()
    {
        return view('livewire.search-clients');
    }
}
