<?php

namespace App\Http\Controllers;

use App\Clients;
use App\Measurer;
use App\Addresses;
use App\Mail\TestEmail;
use App\Project;
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
            'clients' => Clients::all(),
            'measurers' => $measurers,
        ]);
    }

    public function create()
    {
        return view('clients.create', [
            'client' => new Clients,
            'projects' => Project::pluck('name', 'id'),
            'measurers' => Measurer::select('id', 'serial_number')->where('active', false)->get(),
        ]);
    }

    public function store(StoreClientRequest $request)
    {
        $client = Clients::create($request->validated());

        $measurer = Measurer::findOrFail($request->measurer_id);
        $measurer->active = true;
        $measurer->save();

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
            'projects' => Project::pluck('name', 'id'),
            'measurers' => Measurer::select('id', 'serial_number')->where('active', false)->get(),
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

    public function detach(Clients $client)
    {
        $measurer = Measurer::findOrFail($client->measurer_id);
        $measurer->active = false;
        $measurer->save();

        $client->measurer_id = NULL;
        $client->save();

        return redirect()->route('clients.index');
    }

    public function testEmail(Clients $client)
    {
        Mail::to($client->email)
            ->cc('direccion@efigas.com.mx')
            ->send( new TestEmail );

        return redirect()->route('clients.index');
    }
}
