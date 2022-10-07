<?php

namespace App\Http\Livewire\Tables;

use App\Project;
use Livewire\Component;
use App\Traits\WithSorting;
use App\Traits\WithSearching;

class Projects extends Component
{
    use WithSorting;
    use WithSearching;

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function mount()
    {
        $this->sortField = 'name';
    }

    public function render()
    {
        return view('livewire.tables.projects', [
            'projects' => Project::search($this->search)
                        ->orderBy($this->sortField, $this->sortDirection)
                        ->paginate($this->perPage),
        ]);
    }
}
