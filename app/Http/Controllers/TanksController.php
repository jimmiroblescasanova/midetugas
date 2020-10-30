<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTankRequest;
use App\Project;
use App\Tank;
use App\Traits\UpdateProjectTrait;
use Illuminate\Http\Request;

class TanksController extends Controller
{
    use UpdateProjectTrait;

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
        $project->total_capacity += $data['capacity'];

        if ($project->actual_capacity == 0)
        {
            $project['percentage'] =  0;
        } else {
            $this->calculatePercentage($project);
        }
        $project->save();

        Tank::create( $data );

        return redirect()->route('tanks.index');
    }

}
