<?php

namespace App\Http\Controllers;

use App\Addresses;
use App\Http\Requests\SaveAddressRequest;
use App\Client;
use App\Project;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;

class AddressesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Client $client)
    {
        return view('clients.addresses', [
            'client' => $client,
            'projects' => Project::pluck('name', 'id'),
        ]);
    }

    public function update(Client $client, SaveAddressRequest $request)
    {
        $client->update( $request->validated() );

        Flasher::addPreset('dbCreated');
        return redirect()->route('clients.index');
    }
}
