<?php

namespace App\Http\Controllers;

use App\Document;
use App\Price;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $documents = Document::where([
            ['pending', '>', 0.01],
            ['status', '=', 2]
        ])->take(5)->get();

        return view('home', [
            'actual_price' => Price::latest()->first()->price,
            'documents' => $documents,
        ]);
    }
}
