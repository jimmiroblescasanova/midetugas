<?php

namespace App\Http\Livewire;

use App\Client;
use App\Document;
use Livewire\Component;

class CreatePayment extends Component
{
    public $client;
    public $balance = false;
    public $documents;
    public $total;
    public $pay = [];
    public $paymentSum;


    public function mount($id)
    {
        $this->client = Client::find($id);
        $this->documents = Document::where([
            ['client_id', $id],
            ['pending', '>', 0],
            ['status', 2],
        ])->get();
    }

    public function render()
    {
        $this->paymentSum = array_sum($this->pay);

        return view('livewire.create-payment');
    }
}
