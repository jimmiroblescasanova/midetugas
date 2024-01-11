<?php

namespace App\Http\Controllers;

use App\Factor;
use Illuminate\Http\Request;
use Flasher\Laravel\Facade\Flasher;

class FactorsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $factors = Factor::paginate(15);

        return view('factors.index', [
            'factors' => $factors,
        ]);
    }

    public function store(Request $request)
    {
        Factor::create($request->only('psig', 'value'));

        Flasher::addPreset('dbCreated');
        return redirect()->route('factors.index');
    }

    public function edit(Factor $factor)
    {
        return view('factors.edit', compact('factor'));
    }

    public function update(Factor $factor, Request $request)
    {
        $factor->psig = $request->psig;
        $factor->value = $request->value;
        $factor->save();

        Flasher::addSuccess('Registro actualizado');
        return redirect()->route('factors.index');
    }

    public function destroy(Factor $factor)
    {
        $factor->delete();

        Flasher::addPreset('dbDeleted');
        return redirect()->route('factors.index');
    }
}
