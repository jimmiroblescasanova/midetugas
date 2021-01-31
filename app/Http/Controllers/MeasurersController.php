<?php

namespace App\Http\Controllers;

use App\Measurer;
use Illuminate\Http\Request;
use App\Http\Requests\StoreMeasurerRequest;
use App\Http\Requests\UpdateMeasurerRequest;

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
        ]);
    }

    public function create()
    {
        return view('measurers.create', [
            'measurer' => new Measurer(),
        ]);
    }

    public function store(StoreMeasurerRequest $request)
    {
        Measurer::create( $request->validated() );

        return redirect()->route('measurers.index');
    }

    public function edit(Measurer $measurer)
    {
        return view('measurers.edit', [
            'measurer' => $measurer,
        ]);
    }

    public function update(Measurer $measurer, UpdateMeasurerRequest $request)
    {
        $measurer->update( $request->validated() );
        return redirect()->route('measurers.edit', compact('measurer'));
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
