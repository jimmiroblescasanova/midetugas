<?php

namespace App\Http\Controllers;

use App\Addresses;
use App\Clients;
use App\Http\Requests\SaveAddressRequest;
use App\Http\Requests\SaveContactRequest;
use App\Http\Requests\StoreClientRequest;
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

//        return $client;
        return redirect()->route('clients.contacts.add', $client->id);
    }

    public function show(Clients $client)
    {
        return view('clients.show', [
            'client' => $client,
        ]);
    }

    public function contacts($id)
    {
        $client = Clients::find($id);

        return view('clients.contacts', [
            'client' => $client,
        ]);
    }

    public function saveContact(SaveContactRequest $request)
    {
        $client = Clients::find(request('id'));

        $client->update( $request->validated() );

        return redirect()->route('clients.address.add', $client->id);

    }

    public function address($id)
    {
        return view('clients.addresses', [
            'id' => $id,
        ]);
    }

    public function saveAddress(SaveAddressRequest $request)
    {
        Addresses::create( $request->validated() );

        return redirect()->route('clients.index');
    }
}
