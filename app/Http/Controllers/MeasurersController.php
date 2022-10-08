<?php

namespace App\Http\Controllers;

use App\Factor;
use App\Measurer;
use RealRashid\SweetAlert\Facades\Alert;
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
        return view('measurers.index');
    }

    public function create()
    {
        return view('measurers.create', [
            'measurer' => new Measurer(),
            'factors' => Factor::all(),
        ]);
    }

    public function store(StoreMeasurerRequest $request)
    {
        Measurer::create($request->validated());
        Alert::success('Correcto', 'Medidor almacenado correctamente');
        return redirect()->route('measurers.index');
    }

    public function edit(Measurer $measurer)
    {
        return view('measurers.edit', [
            'measurer' => $measurer,
            'factors' => Factor::all(),
        ]);
    }

    public function update(Measurer $measurer, UpdateMeasurerRequest $request)
    {
        $measurer->update($request->validated());
        Alert::success('Actualizado', 'Medidor actualizado correctamente');

        return redirect()->route('measurers.index');
    }

    public function destroy(Measurer $measurer)
    {
        if ($measurer->active == true) {
            Alert::error('Error', 'No se puede eliminar un medidor activo. Se debe des-asociar del cliente primero.');
            return redirect()->back();
        }

        $measurer->delete();
        Alert::info('Eliminado', 'Medidor eliminado correctamente');
        return redirect()->route('measurers.index');
    }
}
