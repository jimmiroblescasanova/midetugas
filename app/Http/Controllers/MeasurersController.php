<?php

namespace App\Http\Controllers;

use App\Clients;
use App\Measurer;
use App\Http\Requests\SaveMeasurerRequest;
use Illuminate\Http\Request;

class MeasurersController extends Controller
{
    public function index()
    {
        return view('measurers.index', [
            'measurers' => Measurer::all(),
            'clients' => Clients::pluck('name', 'id'),
        ]);
    }

    public function create()
    {
        return view('measurers.create', [
            'clients' => Clients::pluck('name', 'id'),
        ]);
    }

    public function store(SaveMeasurerRequest $request)
    {
        Measurer::create( $request->validated() );

        return redirect()->route('measurers.index');
    }

    public function destroy(Request $request)
    {
        Measurer::destroy($request->id);

        return redirect()->route('measurers.index');
    }
}
