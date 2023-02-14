<?php

namespace App\Http\Livewire\Tables;

use App\Client;
use App\Project;
use Livewire\Component;
use App\Traits\WithSorting;
use App\Traits\WithSearching;

class Clients extends Component
{
    use WithSorting;
    use WithSearching;

    public $projects;
    public $project = 'all';

    public function clear()
    {
        $this->reset([
            'search',
            'perPage',
        ]);
        $this->emit('ClearProject');
    }

    public function updatedProject()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->sortField = 'id';
        $this->sortDirection = 'desc';
        $this->projects = Project::pluck('name', 'id');
    }

    public function render()
    {
        return view('livewire.tables.clients', [
            'clientes' => Client::search($this->search)
                    ->when($this->project != 'all', function($q){
                        $q->where('project_id', $this->project);
                    })
                    ->orderBy($this->sortField, $this->sortDirection)
                    ->paginate($this->perPage),
        ]);
    }
}
