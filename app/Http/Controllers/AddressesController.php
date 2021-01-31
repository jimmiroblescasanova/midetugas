<?php

namespace App\Http\Controllers;

use App\Addresses;
use App\Http\Requests\SaveAddressRequest;
use App\Client;
use App\Project;
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
        $data = [
            'line_1' => $request->line_1,
            'line_2' => $request->line_2,
            'line_3' => $request->line_3,
            'locality' => $request->locality,
            'city' => $request->city,
            'state_province' => $request->state_province,
            'country' => $request->country,
            'zipcode' => $request->zipcode,
        ];

        $client->update( $data );

        return redirect()->route('clients.index');
    }
}
