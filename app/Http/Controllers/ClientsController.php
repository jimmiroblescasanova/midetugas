<?php

namespace App\Http\Controllers;

use App\Addresses;
use App\Clients;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    //

    public function index()
    {
        $clients = Clients::all();

        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        return view('clients.create', [
            'client' => new Clients,
        ]);
    }

    public function store(StoreClientRequest $request)
    {
        $client = Clients::create($request->validated());

        return redirect()->route('contacts.create', $client->id);
    }

    public function show(Clients $client)
    {
        if ( !$address = Addresses::where('client_id', $client->id)->first() )
        {
            $address = new Addresses;
        }

        return view('clients.show', [
            'client' => $client,
            'address' => $address,
        ]);
    }

    public function update(Clients $client, UpdateClientRequest $request)
    {
        $client->update( $request->validated() );

        return redirect()->route('clients.index');
    }
}
