<?php

namespace App\Http\Controllers;

use App\Clients;
use App\Deposit;
use App\Http\Requests\StoreDepositRequest;
use Illuminate\Support\Facades\DB;

class DepositsController extends Controller
{
    public function index()
    {
        return view('deposits.index', [
            'deposits' => Deposit::orderBy('id', 'desc')->get(),
        ]);
    }

    public function create()
    {
        return view('deposits.create', [
            'clients' => Clients::where('measurer_id', !NULL)->pluck('name', 'id'),
        ]);
    }

    public function store(StoreDepositRequest $request)
    {

        DB::transaction(function () use ($request) {
            $deposit = Deposit::create( $request->validated() );
            $client = Clients::findOrFail($request['client_id']);
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
//        return $deposit->client;
        return view('print.guarantee', compact('deposit'));
    }
}
