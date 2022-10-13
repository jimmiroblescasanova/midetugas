<?php

namespace App\Http\Controllers;

use App\Factor;
use App\Measurer;
use Flasher\Laravel\Facade\Flasher;
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
            'factors' => Factor::pluck('psig', 'value'),
        ]);
    }

    public function store(StoreMeasurerRequest $request)
    {
        Measurer::create($request->validated());
        Flasher::addPreset('dbCreated');
        return redirect()->route('measurers.index');
    }

    public function edit(Measurer $measurer)
    {
        return view('measurers.edit', [
            'measurer' => $measurer,
            'factors' => Factor::pluck('psig', 'value'),
        ]);
    }

    public function update(Measurer $measurer, UpdateMeasurerRequest $request)
    {
        $measurer->update($request->validated());
        Flasher::addPreset('dbUpdated');

        return redirect()->route('measurers.index');
    }

    public function destroy(Measurer $measurer)
    {
        if ($measurer->active == true) {
            Flasher::addWarning('No se puede eliminar un medidor activo. Se debe des-asociar del cliente primero.');
            return redirect()->back();
        }

        $measurer->delete();
        Flasher::addPreset('dbDeleted');
        return redirect()->route('measurers.index');
    }
}
