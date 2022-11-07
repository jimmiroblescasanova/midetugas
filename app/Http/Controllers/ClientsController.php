<?php

namespace App\Http\Controllers;

use App\Client;
use App\Project;
use App\Measurer;
use App\Mail\TestEmail;
use Maatwebsite\Excel\Excel;
use App\Exports\ClientsExport;
use Illuminate\Support\Facades\DB;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Support\Facades\Log;
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
        return view('clients.index');
    }

    public function create()
    {
        return view('clients.create', [
            'client' => new Client,
            'measurers' => Measurer::where('active', false)->get(),
            'projects' => Project::pluck('name', 'id'),
        ]);
    }

    public function store(StoreClientRequest $request)
    {        
        try {
            DB::beginTransaction();
            $client = Client::create($request->safe()->except('measurer_id'));

            if (array_key_exists('measurer_id', $request->validated())) {
                $measurer = Measurer::findOrFail($request->measurer_id);
                $measurer->client_id = $client->id;
                $measurer->active = true;
                $measurer->save();
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            Log::error($th->getMessage());
            abort(500, $th->getMessage());
        }

        Flasher::addSuccess('Cliente agregado correctamente');
        return redirect()->route('clients.index');
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

        if ($client->measurer()->exists()) {
            $client->measurer->update([
                'client_id' => NULL,
                'active' => false,
            ]);
        }

        if ($request->measurer_id != '0') {
            Measurer::findOrFail($request->measurer_id)->update([
                'client_id' => $client->id,
                'active' => true,
            ]);
        }

        $client->update($request->validated());

        return redirect()->route('clients.index');
    }

    public function status(Client $client)
    {
        $client->status = !$client->status;
        if ($client->reconnection_charge == FALSE) {
            $client->reconnection_charge = TRUE;
        }
        $client->save();

        return redirect()->route('clients.index');
    }

    public function testEmail(Client $client)
    {
        Mail::to($client->email)
            ->cc('direccion@efigas.com.mx')
            ->send(new TestEmail);

        return redirect()->route('clients.index');
    }

    public function export()
    {
        return (new ClientsExport)->download('clientes_' . time() . '.csv', Excel::CSV, ['Content-Type' => 'text/csv']);
    }
}
