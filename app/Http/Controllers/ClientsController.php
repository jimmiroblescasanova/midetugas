<?php

namespace App\Http\Controllers;

use App\admClientes;
use App\Client;
use App\Project;
use App\Measurer;
use App\Mail\TestEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;

class ClientsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $measurers = Measurer::select('id', 'serial_number')->where('active', false)->get();

        return view('clients.index', [
            'clients' => Client::all(),
            'measurers' => $measurers,
        ]);
    }

    public function create()
    {
        return view('clients.create', [
            'client' => new Client,
            'measurers' => Measurer::where('active', false)->get(),
        ]);
    }

    public function store(StoreClientRequest $request)
    {
        $client = Client::create($request->validated());

        if ($request['measurer_id'] != 'NULL')
        {
            $measurer = Measurer::findOrFail($request->measurer_id);
            $measurer->client_id = $client->id;
            $measurer->active = true;
            $measurer->save();
        }

        return redirect()->route('contacts.create', $client->id);
    }

    public function show(Client $client)
    {
        return view('clients.show', [
            'client' => $client,
            'projects' => Project::pluck('name', 'id'),
            'measurers' => Measurer::where('client_id', NULL)->get(),
        ]);
    }

    public function update(Client $client, UpdateClientRequest $request)
    {

        if($client->measurer()->exists()){
            $client->measurer->update([
            'client_id' => NULL,
            ]);
        }

        if ($request->measurer_id != '0')
        {
            Measurer::findOrFail($request->measurer_id)->update([
            'client_id' => $client->id,
            ]);

        }

        $client->update( $request->validated() );

        return redirect()->route('clients.index');
    }

    public function attach(Request $request)
    {
        $client = Client::findOrFail($request->client_id);
        $client->measurer_id = $request->measurer_id;
        $client->save();

        $measurer = Measurer::findOrFail($request->measurer_id);
        $measurer->active = true;
        $measurer->save();

        return redirect()->route('clients.index');
    }

    public function detach(Client $client)
    {
        $measurer = Measurer::where('client_id', $client->id)->first();
        $measurer->active = false;
        $measurer->client_id = NULL;
        $measurer->save();

        return redirect()->route('clients.index');
    }

    public function status(Client $client)
    {
        $client->status = !$client->status;
        if ($client->reconnection_charge == FALSE)
        {
            $client->reconnection_charge = TRUE;
        }
        $client->save();

        return redirect()->route('clients.index');
    }

    public function testEmail(Client $client)
    {
        Mail::to($client->email)
            ->cc('direccion@efigas.com.mx')
            ->send( new TestEmail );

        return redirect()->route('clients.index');
    }

    public function link_client(Client $client)
    {
        $id = admClientes::orderBy('CIDCLIENTEPROVEEDOR', 'DESC')->first()->CIDCLIENTEPROVEEDOR;

        $client_linked = admClientes::create(
            [
                'CIDCLIENTEPROVEEDOR' => $id+1,
                'CCODIGOCLIENTE' => 'SMART'.$client['id'],
                'CRAZONSOCIAL' => $client['name'],
                'CFECHAALTA' => NOW(),
                'CRFC' => $client['rfc'],
                'CIDMONEDA' => '1',
                'CLISTAPRECIOCLIENTE' => '1',
                'CBANVENTACREDITO' => '1',
                'CTIPOCLIENTE' => '1',
                'CESTATUS' => '1',
                'CDIAPAGO' => '31',
                'CDIASREVISION' => '31',
                'CDIASEMBARQUECLIENTE' => '31',
                'CDIASEMBARQUEPROVEEDOR' => '31',
                'CTEXTOEXTRA3' => 'web',
                'CBANCREDITOYCOBRANZA' => '1',
                'CBANENVIO' => '1',
                'CBANAGENTE' => '1',
                'CBANIMPUESTO' => '1',
                'CTIMESTAMP' => NOW(),
                'CIDMONEDA2' => '1',
                'CEMAIL1' => $client['email'],
                'CIDADDENDA' => '-1',
                'CIDCOMPLEM' => '-1',
            ]
        );

        $client->update([
            'admCode' => $id+1
        ]);
        $client->save();

        return $client_linked;
    }

}
