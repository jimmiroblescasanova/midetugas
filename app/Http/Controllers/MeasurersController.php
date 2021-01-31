<?php

namespace App\Http\Controllers;

use App\Client;
use App\Measurer;
use Illuminate\Http\Request;
use App\Http\Requests\SaveMeasurerRequest;

class MeasurersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('measurers.index', [
            'measurers' => Measurer::all(),
            'clients' => Client::pluck('name', 'id'),
        ]);
    }

    public function create()
    {
        return view('measurers.create', [
            'clients' => Client::pluck('name', 'id'),
        ]);
    }

    public function store(SaveMeasurerRequest $request)
    {
        Measurer::create( $request->validated() );

        return redirect()->route('measurers.index');
    }

    public function destroy(Request $request)
    {
        $measurer = Measurer::findOrFail($request->id);

        if ($measurer->active == true)
        {
            return redirect()->back()->with('message', 'No se puede eliminar un medidor activo. Se debe des-asociar del cliente primero.');
        }

        $measurer->delete();

        return redirect()->route('measurers.index');
    }

}
