<?php

namespace App\Http\Controllers;

use App\Addresses;
use App\Http\Requests\SaveAddressRequest;
use Illuminate\Http\Request;

class AddressesController extends Controller
{
    public function create($id)
    {
        return view('clients.addresses', [
            'id' => $id,
            'address' => new Addresses,
        ]);
    }

    public function store(SaveAddressRequest $request)
    {
        Addresses::create( $request->validated() );

        return redirect()->route('clients.index');
    }

    public function update(SaveAddressRequest $request)
    {
        Addresses::updateOrCreate(
            ['client_id' => $request->client_id],
            [
                'line_1' => $request->line_1,
                'line_2' => $request->line_2,
                'line_3' => $request->line_3,
                'locality' => $request->locality,
                'city' => $request->city,
                'state_province' => $request->state_province,
                'country' => $request->country,
                'zipcode' => $request->zipcode,
            ]
        );

        return redirect()->route('clients.index');
    }
}
