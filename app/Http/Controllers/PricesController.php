<?php

namespace App\Http\Controllers;

use App\Price;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PricesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $data = Validator::make($request->all(), [
            'price' => 'required|numeric',
        ])->validate();

        Price::create( $data );

        return redirect()->route('home');
    }
}
