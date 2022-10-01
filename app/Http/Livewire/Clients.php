<?php

namespace App\Http\Livewire;

use App\Client;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Excel;
use Livewire\WithFileUploads;
use App\Exports\ClientsExport;
use App\Imports\ClientsImport;
use Maatwebsite\Excel\Facades\Excel as ExcelImport;

class Clients extends Component
{
    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search = "";
    public $perPage = 10;
    public $orderColumn = 'id';
    public $orientation = 'asc';

    public $file;

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

    public function export()
    {
        return (new ClientsExport($this->search))->download('clientes_'.time().'.csv', Excel::CSV, ['Content-Type' => 'text/csv']);
    }

    public function importClients()
    {
        $this->validate([
            'file' => 'required|mimes:csv,txt',
        ]);

        ExcelImport::import(new ClientsImport, $this->file);

        $this->reset();
        $this->emit('forceCloseModal');
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
