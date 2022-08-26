<?php

namespace App\Http\Controllers\Livewire;

use App\Client;
use Livewire\Component;

class CreatePayment extends Component
{
    public $client;
    public $total;
    public $pay = [];
    public $paymentSum;


    public function mount($id)
    {
        $this->client = Client::find($id);
    }

    public function render()
    {
        $this->paymentSum = array_sum($this->pay);

        return view('livewire.create-payment');
    }
}
