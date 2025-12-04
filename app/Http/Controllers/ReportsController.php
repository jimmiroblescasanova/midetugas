<?php

namespace App\Http\Controllers;

use App\Client;
use App\Project;
use App\Document;
use App\Services\ReportsBillingService;
use App\Services\ReportsDocumentListService;
use http\Exception;
use Illuminate\Http\Request;
use App\Exports\EdcExportReport;
use Illuminate\Support\Facades\DB;
use App\Exports\AccountStatusReport;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use App\Http\Requests\ClientBalanceReportRequest;

class ReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function parametrosTomaDeLectura()
    {
        return view('reports.lecture.parameters', [
            'projects' => Project::orderBy('name', 'asc')->pluck('name', 'id'),
        ]);
    }

    public function pdfTomaDeLectura(Request $request)
    {
        $project = Project::find($request->project_id);
        $clients = Client::where('project_id', $project->id)->orderBy('name', $request['order'])->get();

        // Generar el PDF
        $pdf = PDF::loadView('reports.lecture.print', [
            'clients' => $clients,
            'project' => $project,
        ]);
        $pdf->setPaper('statement', 'portrait');
        return $pdf->stream();
    }

    public function parametrosCobranza()
    {
        $years = DB::table('documents')->selectRaw('year(date) as year')
            ->where('status', '2')
            ->orWhere('status', '4')
            ->groupBy('year')
            ->orderByDesc('year')
            ->pluck('year');

        $projects = Project::orderBy('name', 'asc')->pluck('name', 'id');

        return view('reports.cobranza.index',[
            'projects' => $projects,
            'years' => $years,
        ]);
    }

    public function pdfCobranza(Request $request)
    {
        $clients = Client::where('project_id', $request->project)->pluck('id');

        $documents = Document::whereIn('client_id', $clients)
        ->whereMonth('date', '<=', $request['month'])
        ->whereYear('date', '<=', $request['year'])
        ->groupBy('client_id')
        ->selectRaw('client_id, SUM(total) as suma, SUM(pending) as pendiente')
        ->get();

        // Generar el PDF
        $pdf = PDF::loadView('reports.cobranza.print', [
        'documents' => $documents,
        ]);
        $pdf->setPaper('statement', 'portrait');
        return $pdf->stream();
    }

    public function excelCobranza(ClientBalanceReportRequest $request)
    {
        return Excel::download(new AccountStatusReport($request), 'cobranza.xlsx');
    }

    public function edcParameters()
    {
        $years = DB::table('documents')->selectRaw('year(date) as year')
        ->where('status', '2')
        ->orWhere('status', '4')
        ->groupBy('year')
        ->orderByDesc('year')
        ->get();

        $clients = Client::query()
        ->where('status', 0)
        ->orderBy('name', 'asc')
        ->get();

        return view('reports.edc.parameters', [
            'clients' => $clients,
            'years' => $years
        ]);
    }

    public function edcScreen(Request $request)
    {
        if($request->ajax())
        {
            $documents = Document::where('client_id', $request->client)
                ->where('status', 2)
                ->when(!$request->allDocuments, function ($q) use ($request){
                    $q->where('pending', '>', 0);
                })
                ->whereYear('date', '>=', $request->year)
                ->whereMonth('date', '>=', $request->month)
                ->with('client')
                ->get();

            return response()->json([
                'status' => 'OK',
                'documents' => $documents,
            ], 200);
        }
    }

    public function edcExportExcel(Request $request)
    {
        return Excel::download( new EdcExportReport($request), 'estado_de_cuenta.xlsx');
    }

    public function listaRecibos()
    {
        $years = $this->getYears();

        $projects = Project::pluck('name', 'id');

        return view('reports.lista-recibos.parameters', [
            'select_years' => $years,
            'projects' => $projects,
        ]);
    }

    /**
     * @throws \Exception
     */
    public function listaRecibosExecute(Request $request, ReportsDocumentListService $service)
    {
        // Validate the year, month, and project (exists on table projects)
        $data = $request->validate([
            'year' => 'required|integer|min:2000|max:2100',
            'month' => 'required|digits_between:1,12',
            'project_id' => 'required|exists:projects,id',
            'columns' => 'nullable|array',
        ]);


        return match ($request->input('action')) {
            'pdf' => $service->generatePdf($data),
            'excel' => $service->generateXls($data),
            default => throw new \Exception('Invalid action'),
        };
    }

    /**
     * Show billing report parameters view.
     */
    public function billing(): View
    {
        return view('reports.billing.parameters', [
            'years' => $this->getYears(),
            'projects' => Project::pluck('name', 'id'),
        ]);
    }

    /**
     * Ejecuta el reporte de cobranza según los parámetros enviados.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Services\ReportsBillingService $service
     *
     * @return mixed Resultado de la generación del servicio (PDF o Excel).
     *
     * @throws \Exception Si la acción no es válida.
     */
    public function billingExecute(Request $request, ReportsBillingService $service)
    {
        // Validate the year, month, and project (exists on table projects)
        $data = $request->validate([
            'year' => 'required|integer|min:2000|max:2100',
            'month' => 'required|digits_between:1,12',
            'project_id' => 'required|exists:projects,id',
            'columns' => 'nullable|array',
        ]);

        return match ($request->input('action')) {
            'pdf' => $service->generatePdf($data),
            'excel' => $service->generateXls($data),
            default => throw new \Exception('Invalid action'),
        };
    }

    protected function getYears(): array
    {
        return DB::table('documents')
            ->selectRaw('YEAR(date) as year')
            ->whereIn('status', [2, 4])
            ->groupBy('year')
            ->orderByDesc('year')
            ->pluck('year')
            ->toArray();
    }
}
