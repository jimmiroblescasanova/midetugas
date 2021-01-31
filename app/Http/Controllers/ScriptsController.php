<?php

namespace App\Http\Controllers;

use App\Client;
use App\Addresses;

class ScriptsController extends Controller
{
    public function migrateAddresses()
    {
        $direcciones = Addresses::all();

        foreach($direcciones as $direccion)
        {
            $client = Client::find($direccion->client_id);
            $client->line_1 = $direccion->line_1;
            $client->line_2 = $direccion->line_2;
            $client->line_3 = $direccion->line_3;
            $client->locality = $direccion->locality;
            $client->city = $direccion->city;
            $client->state_province = $direccion->state_province;
            $client->country = $direccion->country;
            $client->zipcode = $direccion->zipcode;
            $client->save();
        }
    }
}
