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
        $factors = Factor::paginate();

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

    public function destroy(Request $request)
    {
        Factor::find($request->id)->delete();

        Flasher::addPreset('dbDeleted');
        return redirect()->route('factors.index');
    }
}
