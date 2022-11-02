<?php

namespace App\Http\Controllers;

use App\Price;
use App\Payment;
use App\Project;
use App\Document;
use Carbon\Carbon;

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
        $projects = Project::query()
            ->select('name', 'total_capacity', 'actual_capacity')
            ->get();

        $chart['label'] = [];
        $chart['total_capacity'] = [];
        $chart['actual_capacity'] = [];
        foreach ($projects as $data)
        {
            array_push($chart['label'], $data->name);
            array_push($chart['total_capacity'], $data->total_capacity);
            array_push($chart['actual_capacity'], $data->actual_capacity);
        }

        $today_payments = Payment::query()
            ->whereDate('created_at', Carbon::today())
            ->sum('amount');

        $pending_doctos = Document::query()
            ->where('status', '1')
            ->count();

        return view('home', [
            'actual_price' => Price::latest()->first()->price,
            'pending_doctos' => $pending_doctos,
            'today_payments' => $today_payments / 100,
            'chart' => $chart,
        ]);
    }
}
