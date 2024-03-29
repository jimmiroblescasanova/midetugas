<?php 

namespace App\Traits;

use App\Document;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

trait GetPDFTrait
{
    use GraphBarTrait;

    public function generarPDF($docto)
    {
        // Se obtiene los históricos de meses anteriores
        $historic = Document::select('id', 'period', 'month_quantity', 'correction_factor', 'total')
            ->where([
                ['client_id', $docto->client_id],
                ['id', '<=', $docto->id],
                ['status', '!=', 3]
            ])->orderByDesc('id')->get();

        // Trait to generate the chart
        $chart = $this->generateChart($historic);

        // Generar el PDF
        $pdf = PDF::loadView('print.document', [
            'docto' => $docto,
            'acumulado' => $this->calcularAcumulado($docto->client_id, $docto->date),
            'chart' => urlencode($chart),
            'historic' => $historic->take(2),
        ]);
        $pdf->setPaper('A4', 'portrait');
        return $pdf;
    }

    protected function calcularAcumulado($client, $date): int
    {
        // calcular el acumulado de saldos
        $acumulado = Document::where([
            ['client_id', $client],
            ['status', 2],
            ['date', '<', $date]
        ])->sum('pending');

        return $acumulado;
    }
}