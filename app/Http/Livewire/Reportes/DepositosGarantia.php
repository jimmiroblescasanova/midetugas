<?php

namespace App\Http\Livewire\Reportes;

use App\Client;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class DepositosGarantia extends Component
{
    public $allClients;
    public $year = 'all';
    public $month = 'all';
    public $client = 'all';
    public $depositos = [];
    public $acumulado = 0;

    protected $listeners = ['getResults' => 'ejecutarReporte'];

    public function ejecutarReporte()
    {
        $results = DB::table('deposits')
            ->join('clients', 'deposits.client_id', '=', 'clients.id')
            ->select('clients.name as name', 'total', 'date')
            ->when($this->year != 'all', function ($q) {
                $q->whereYear('date', $this->year);
            })
            ->when($this->month != 'all', function ($q) {
                $q->whereMonth('date', $this->month);
            })
            ->when($this->client != 'all', function ($q) {
                $q->where('client_id', $this->client);
            })
            ->get();

            $this->depositos = $results->toArray();
            $this->acumulado = $results->sum('total');
    }

    public function mount()
    {
        $this->allClients = Client::all();
    }

    public function render()
    {
        return view('livewire.reportes.depositos-garantia');
    }
}
