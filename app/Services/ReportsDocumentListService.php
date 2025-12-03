<?php

declare(strict_types=1);

namespace App\Services;

use App\Client;
use App\Document;
use App\Exports\DocumentsListExport;
use App\Project;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Exception;

class ReportsDocumentListService
{
    /**
     * Genera un reporte PDF de lista de recibos.
     *
     * @param array $params Parámetros para generar el reporte, incluyendo:
     *                      - 'project_id': ID del proyecto.
     *                      - 'year': Año de los documentos.
     *                      - 'month': Mes de los documentos.
     *                      - 'columns': Columnas a incluir en el reporte.
     *                      - 'filename' (opcional): Nombre del archivo PDF resultante.
     *
     * @return \Illuminate\Http\Response Respuesta HTTP con el PDF generado.
     */
    public function generatePdf(array $params): \Illuminate\Http\Response
    {
        $documents = $this->getDocumentsFromQuery($params);

        $pdf = Pdf::loadView('reports.lista-recibos.pdf-report', [
            'documents' => $documents,
            'columns' => $params['columns'],
        ]);

        // Nombre de archivo por defecto o pasado en $params['filename']
        $fileName = isset($params['filename']) && $params['filename']
            ? $params['filename']
            : 'lista_recibos_' . $params['year'] . '_' . str_pad((string) $params['month'], 2, '0', STR_PAD_LEFT) . '.pdf';

         return $pdf->stream($fileName);
    }

    /**
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function generateXls(array $params): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $filename = 'lista_recibos_' . $params['year'] . '_' . str_pad((string) $params['month'], 2, '0', STR_PAD_LEFT) . '.xlsx';
        $documents = $this->getDocumentsFromQuery($params);
        $project = Project::find($params['project_id']);

        return Excel::download(new DocumentsListExport($documents, $project, $params['columns']), $filename);
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
