<?php

namespace App\Http\Controllers;

use App\Clients;
use App\Http\Requests\SaveContactRequest;
use Illuminate\Http\Request;

class ContactsController extends Controller
{
    public function create($id)
    {
        $client = Clients::find($id);

        return view('clients.contacts', [
            'client' => $client,
        ]);
    }

    public function store(Clients $client, SaveContactRequest $request)
    {
        $client->update( $request->validated() );

        return redirect()->route('address.create', $client->id);
    }

    public function update(Clients $client, SaveContactRequest $request)
    {
        $client->update( $request->validated() );

        return redirect()->route('clients.index');
    }
}
