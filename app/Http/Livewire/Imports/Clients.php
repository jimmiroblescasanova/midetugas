<?php

namespace App\Http\Livewire\Imports;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Imports\ClientsImport;
use Flasher\Laravel\Facade\Flasher;
use Maatwebsite\Excel\Facades\Excel as ExcelImport;

class Clients extends Component
{
    use WithFileUploads;

    public $file;
    public $failures = null;

    public function importClients()
    {
        $this->validate([
            'file' => 'required|mimes:csv,txt',
        ]);

        try {
            ExcelImport::import(new ClientsImport, $this->file);
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            return $this->failures = $e->failures();
        }

        $this->reset();
        $this->emit('forceCloseModal');

        Flasher::addSuccess('Carga completada.');
    }

    public function render()
    {
        return view('livewire.imports.clients');
    }
}
