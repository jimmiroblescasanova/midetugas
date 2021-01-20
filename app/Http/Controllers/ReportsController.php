<?php

namespace App\Http\Controllers;

use App\Clients;
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
        $clients = Clients::where('project_id', $project->id)->orderBy('name', $request['order'])->get();

        // Generar el PDF
        $pdf = \PDF::loadView('reports.lecture.print', [
            'clients' => $clients,
            'project' => $project,
        ]);
        $pdf->setPaper('statement', 'portrait');
        return $pdf->stream();
    }
}
