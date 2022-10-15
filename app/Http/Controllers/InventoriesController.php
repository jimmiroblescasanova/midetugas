<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInventoryRequest;
use App\Http\Resources\TankResource;
use App\Traits\UpdateProjectTrait;
use App\Inventory;
use App\Project;
use App\Tank;
use Illuminate\Http\Request;

class InventoriesController extends Controller
{
    use UpdateProjectTrait;

    public function __construct()
    {
        $this->middleware('auth')->except('fillTanks');
    }

    public function index()
    {
        return view('inventories.index', [
            'inventories' => Inventory::orderBy('date', 'asc')->get(),
        ]);
    }

    public function create()
    {
        return view('inventories.create', [
            'projects' => Project::pluck('name', 'id'),
        ]);
    }

    public function store(StoreInventoryRequest $request)
    {
        $project = Project::findOrFail($request->project_id);
        $new_total = $project->actual_capacity + $request->quantity;

        if ($project->total_capacity >= $new_total) {
            $project->actual_capacity = $new_total;
            $project->percentage = $this->calculatePercentage($project);
            $project->save();

            Inventory::create($request->validated());
        }

        return redirect()->route('inventories.index');
    }

    public function fillTanks()
    {
        $tanks = Tank::select('id', 'brand', 'model', 'serial_number')
            ->where('project_id', request()->input('project_id'))
            ->get();

        return TankResource::collection($tanks);
    }

    public function show(Inventory $inventory)
    {
        return view('inventories.show', [
            'inventory' => $inventory,
        ]);
    }
}
