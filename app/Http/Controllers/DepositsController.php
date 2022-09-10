<?php

namespace App\Http\Controllers;

use App\Client;
use App\Deposit;
use Illuminate\Support\Facades\DB;
use Luecano\NumeroALetras\NumeroALetras;
use App\Http\Requests\StoreDepositRequest;

class DepositsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('deposits.index', [
            'deposits' => Deposit::orderBy('id', 'desc')->get(),
        ]);
    }

    public function create()
    {
        return view('deposits.create', [
            'clients' => Client::pluck('name', 'id'),
        ]);
    }

    public function store(StoreDepositRequest $request)
    {

        DB::transaction(function () use ($request) {
            Deposit::create( $request->validated() );
            $client = Client::findOrFail($request['client_id']);
            $client->deposit += $request['total'];
            $client->save();
        });

        /*DB::beginTransaction();
        try {
            DB::table('deposits')->insert( $request->validated() );
            DB::table('clients')->where('id', $request['client_id'])->update([
                'deposit' => $request['total'],
            ]);
            DB::commit();
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            return $e;
        }*/

        return redirect()->route('deposits.index');
    }

    public function show(Deposit $deposit)
    {
        $formatter = new NumeroALetras();
        $letras = $formatter->toMoney($deposit['total'], 2, 'pesos', 'centavos');

        // Generar el PDF
        $pdf = \PDF::loadView('print.guarantee', [
            'deposit' => $deposit,
            'letras' => $letras,
        ]);
        $pdf->setPaper('statement', 'portrait');
        return $pdf->stream();
    }

    public function cancel(Deposit $deposit)
    {
        $client = Client::find( $deposit->client_id );
        $client->deposit = $client->deposit - $deposit->total;
        $client->save();

        $deposit->active = false;
        $deposit->save();

        return redirect()->route('deposits.index');
    }
}
