<?php

namespace App\Http\Controllers;

use App\Client;
use App\Document;
use App\Exports\AccountStatusReport;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReportsController extends Controller
{
    public function lectureReportParameters()
    {
        return view('reports.lecture.parameters', [
            'projects' => Project::all(),
        ]);
    }

    public function lectureReport(Request $request)
    {
        $project = Project::find($request->project_id);
        $clients = Client::where('project_id', $project->id)->orderBy('name', $request['order'])->get();

        // Generar el PDF
        $pdf = \PDF::loadView('reports.lecture.print', [
            'clients' => $clients,
            'project' => $project,
        ]);
        $pdf->setPaper('statement', 'portrait');
        return $pdf->stream();
    }

    public function accountStatusParameters()
    {
        $years = DB::table('documents')->selectRaw('year(date) as year')
            ->where('status', '2')
            ->orWhere('status', '4')
            ->groupBy('year')
            ->orderByDesc('year')
            ->get();


        return view('reports.account-status.index',[
            'clients' => Client::pluck('name', 'id'),
            'years' => $years,
        ]);
    }

    public function accountStatusAjax(Request $request)
    {
        if ($request->ajax())
        {
            if ($request['client_first'] > $request['client_last'])
            {
                return response()->json([
                    'error' => 'El cliente inicial no puede ser mayor que el cliente final',
                ], 400);
            }

            $documents = Document::where('status', '!=', 3)
                ->whereBetween('client_id', [$request['client_first'], $request['client_last']])
                ->whereMonth('date', '=', $request['month'])
                ->whereYear('date', '=', $request['year'])
                ->with('client')
                ->get();


            return response()->json([
                'documents' => $documents,
            ], 200);
        }

    }

    public function accountStatusExcel(Request $request)
    {
        $request->validate([
            'client_first' => 'required|lte:client_last',
            'client_last' => 'required'
        ], [
            'client_first.lte' => 'El cliente inicial no puede ser mayor que el cliente final'
        ]);

        return Excel::download(new AccountStatusReport($request), 'invoices.xlsx');
    }
}
