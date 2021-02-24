<?php

declare(strict_types = 1);

namespace App\Charts;

use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeChart extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     * @param Request $request
     * @return Chartisan
     */
    public function handler(Request $request): Chartisan
    {
        $documents = DB::table('documents')
            ->select(DB::raw('period, year(date) as year, month(date) as month, SUM(total) as total_amount, SUM(pending) as total_pending'))
            ->where('status', '2')
            ->orWhere('status', '4')
            ->groupBy('period', 'month', 'year')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $dates = [];
        $total = [];
        $pending = [];

        foreach ($documents as $document)
        {
            array_push( $dates, $document->period);
            array_push( $total, $document->total_amount);
            array_push( $pending, $document->total_pending);
        }

        return Chartisan::build()
            ->labels($dates)
            ->dataset('Facturado', $total)
            ->dataset('Pendiente de pago', $pending);
    }
}
