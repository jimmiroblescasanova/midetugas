<?php

namespace App\Http\Controllers;

use App\Factor;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class FactorsController extends Controller
{
    public function index()
    {
        $factors = Factor::all();

        return view('factors.index', [
            'factors' => $factors,
        ]);
    }

    public function store(Request $request)
    {
        Factor::create($request->only('psig', 'value'));

        Alert::success('Éxito', 'El registro se ha guardado con éxito.');
        return redirect()->route('factors.index');
    }

    public function destroy(Request $request)
    {
        Factor::find($request->id)->delete();

        Alert::success('Éxito', 'El registro se ha eliminado con éxito.');
        return redirect()->route('factors.index');
    }
}
