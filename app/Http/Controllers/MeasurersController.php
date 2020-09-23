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
        $measurer = Measurer::findOrFail($request->id);

        if ($measurer->active == true)
        {
            return redirect()->back()->with('message', 'No se puede eliminar un medidor activo. Se debe des-asociar del cliente primero.');
        }

        $measurer->delete();

        return redirect()->route('measurers.index');
    }

}
