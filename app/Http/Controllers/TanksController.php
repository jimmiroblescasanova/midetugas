<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTankRequest;
use App\Project;
use App\Tank;
use Illuminate\Http\Request;

class TanksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('tanks.index', [
            'tanks' => Tank::all(),
        ]);
    }

    public function create()
    {
        return view('tanks.create', [
            'projects' => Project::pluck('name', 'id'),
        ]);
    }

    public function store(StoreTankRequest $request)
    {
        $data = $request->validated();

        $project = Project::find($data['project_id']);

        $percentage = $this->calculatePercentage($project->total_capacity, $project->new_capacity, $data['capacity']);

        $project->total_capacity = $project->total_capacity + $data['capacity'];
        $project->percentage = $percentage;
        $project->save();

        Tank::create( $data );

        return redirect()->route('tanks.index');
    }

    private function calculatePercentage($total, $actual, $new)
    {
        if ($total == 0)
        {
            return 0;
        }
        $new_total = $total + $new;
        $percentage = (1-(($new_total - $actual) / $new_total)) * 100;

        return $percentage;
    }
}
