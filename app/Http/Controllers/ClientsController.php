<?php

namespace App\Http\Controllers;

use App\Clients;
use App\Http\Requests\StoreClientRequest;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    //

    public function index()
    {
        $clients = Clients::all();

        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(StoreClientRequest $request)
    {
        Clients::create( $request->validated() );

        return redirect()->route('clients.index');
    }
}
