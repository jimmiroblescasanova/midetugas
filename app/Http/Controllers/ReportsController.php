<?php

namespace App\Http\Controllers;

use App\Client;
use App\Document;
use App\Project;
use Illuminate\Http\Request;

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
        return view('reports.account-status.index',[
            'clients' => Client::pluck('name', 'id'),
        ]);
    }

    public function accountStatusAjax(Request $request)
    {
        if ($request->ajax())
        {
            $request->validate([
                'year' => 'required|digits:4',
            ], [
                'year.required' => 'El año es obligatorio.',
                'year.digits' => 'El año debe ser 4 dígitos.',
            ]);

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
}
