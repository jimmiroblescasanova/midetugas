<?php

namespace App\Services;

use App\Client;
use App\Document;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\Exception;

class ReportsBillingService
{
    /**
     * Genera un reporte PDF de cobranza.
     *
     * @param array $params Parámetros para generar el reporte
     * @return \Illuminate\Http\Response Respuesta HTTP con el PDF generado.
     */
    public function generatePdf(array $params): \Illuminate\Http\Response
    {
        $documents = $this->getDocumentsFromQuery($params);

        $pdf = Pdf::loadView('reports.billing.pdf-report', [
            'columns' => $params['columns'],
            'documents' => $documents
        ]);

        return $pdf->stream('billing-report.pdf');
    }


    /**
     * Generates an XLSX billing report.
     * @param array $params Parameters for generating the report
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     *
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function generateXls(array $params): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $filename = 'billing_report_' . $params['year'] . '_' . str_pad((string) $params['month'], 2, '0', STR_PAD_LEFT) . '.xlsx';
        $documents = $this->getDocumentsFromQuery($params);

        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\BillingReportExport($documents, $params['columns']),
            $filename
        );
    }

    protected function getDocumentsFromQuery(array $params): \Illuminate\Database\Eloquent\Collection
    {
        $clients = Client::where('project_id', $params['project_id'])->pluck('id')->toArray();

        return Document::with(['client', 'client.project'])
            ->whereIn('client_id', $clients)
            ->whereYear('date', $params['year'])
            ->whereMonth('date', $params['month'])
            ->where('status', '2')
            ->orderBy('id')
            ->get();
    }
}
