<?php

namespace App\Http\Controllers;

use App\Client;
use App\Addresses;
use App\Document;

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

    public function calculateIvaColumn()
    {
        $documents = Document::where('status', '!=', '3')->get();

        foreach ($documents as $document)
        {
            echo "ID: {$document->id}... <br>";
            $client = Client::find($document->client_id);

            $subtotal = (100 + ($document->month_quantity * $document->correction_factor) * $document->price);
            $iva = ($subtotal * 1.16) - $subtotal;
            $total = $subtotal + $iva;
            $arr_total = explode('.', round($total,2));

            $document->subtotal = $subtotal;
            $document->iva = $iva;
            $document->total = $arr_total[0];
            $document->pending = $arr_total[0];
            $document->save();
            $client->balance = $arr_total[1];
            $client->save();
        }
        echo "Done.";
    }
}
