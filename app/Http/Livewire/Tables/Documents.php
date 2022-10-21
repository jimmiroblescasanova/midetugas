<?php

namespace App\Http\Livewire\Tables;

use App\Client;
use App\Project;
use App\Document;
use Livewire\Component;
use App\Traits\WithSorting;
use App\Traits\WithSearching;

class Documents extends Component
{
    use WithSorting;
    use WithSearching;

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
        'project' => ['except' => 'all'],
        'status' => ['except' => 'all'],
    ];

    public $projects;
    public $project = 'all';
    public $status = 'all';
    public $clientsOnProject;

    public function clear()
    {
        $this->reset([
            'search',
            'perPage',
            'status',
        ]);
        $this->emit('ClearProject');
    }

    public function updatedProject()
    {
        $this->clientsOnProject = Client::where('project_id', $this->project)->pluck('id')->toArray();
        $this->resetPage();
    }

    public function mount()
    {
        $this->sortField = 'id';
        $this->sortDirection = 'DESC';
        $this->projects = Project::pluck('name', 'id');
    }

    public function render()
    {
        return view('livewire.tables.documents', [
            'documents' => Document::withClientName()->search($this->search)
            ->when($this->project != 'all', function ($q) {
                $q->whereIn('client_id', $this->clientsOnProject);
            })
            ->when($this->status != 'all', function ($q) {
                $q->where('documents.status', $this->status);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage),
        ]);
    }
}
