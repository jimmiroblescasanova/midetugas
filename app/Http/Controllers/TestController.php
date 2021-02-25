<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function index()
    {
        $documents = DB::table('documents')
            ->select(DB::raw('period, year(date) as year, month(date) as month, SUM(total) as total_amount, SUM(pending) as total_pending'))
            ->where('status', '2')
            ->orWhere('status', '4')
            ->groupBy('period', 'month', 'year')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        return $documents->reverse()->take(2);
    }
}
