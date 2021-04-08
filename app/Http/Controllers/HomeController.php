<?php

namespace App\Http\Controllers;

use App\Price;
use App\Document;
use Illuminate\Support\Facades\DB;

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
        $datasets = DB::table('documents')
            ->select(DB::raw('period, year(date) as year, month(date) as month, SUM(total) as total_amount, SUM(pending) as total_pending'))
            ->where('status', '2')
            ->orWhere('status', '4')
            ->groupBy('period', 'month', 'year')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $chart['label'] = [];
        $chart['total_amount'] = [];
        $chart['total_pending'] = [];
        foreach ($datasets->reverse()->take(12) as $data)
        {
            array_push($chart['label'], $data->period);
            array_push($chart['total_amount'], $data->total_amount);
            array_push($chart['total_pending'], $data->total_pending);
        }

        $documents = Document::where([
            ['pending', '>', 0.01],
            ['status', '!=', 1]
        ])->take(10)->get();

        return view('home', [
            'actual_price' => Price::latest()->first()->price,
            'documents' => $documents,
            'chart' => $chart,
        ]);
    }
}
