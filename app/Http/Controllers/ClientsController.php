<?php

namespace App\Http\Controllers;

use App\Addresses;
use App\Clients;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Measurer;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    //

    public function index()
    {
        $measurers = Measurer::select('id', 'code', 'serial_number')->where('active', false)->get();

        return view('clients.index', [
            'clients' => Clients::all(),
            'measurers' => $measurers,
        ]);
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

    public function attach(Request $request)
    {
        $client = Clients::findOrFail($request->client_id);
        $client->measurer_id = $request->measurer_id;
        $client->save();

        $measurer = Measurer::findOrFail($request->measurer_id);
        $measurer->active = true;
        $measurer->save();

        return redirect()->route('clients.index');
    }
}
