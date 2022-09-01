<?php

namespace App\Http\Controllers;

use App\Factor;
use Illuminate\Http\Request;

class FactorsController extends Controller
{
    public function index()
    {
        $factors = Factor::all();
        // return $factors;

        return view('factors.index', [
            'factors' => $factors,
        ]);
    }

    public function store(Request $request)
    {
        $factor = Factor::create($request->only('psig', 'value'));

        return redirect()->route('factors.index');
    }
}
