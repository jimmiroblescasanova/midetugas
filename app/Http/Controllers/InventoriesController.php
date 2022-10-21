<?php

namespace App\Http\Controllers;

use App\Tank;
use App\Project;
use App\Inventory;
use App\Traits\UpdateProjectTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Flasher\Laravel\Facade\Flasher;
use App\Http\Resources\TankResource;
use App\Http\Requests\StoreInventoryRequest;

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
            'inventories' => Inventory::orderBy('date', 'asc')->paginate(),
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

        Flasher::addPreset('dbCreated');
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
            'inventory' => $inventory->load(['project:id,name', 'tank:id,model,serial_number']),
        ]);
    }

    public function destroy(Inventory $inventory)
    {
        // total final al descontar la cantidad a eliminar
        $result = $inventory->project->actual_capacity - $inventory->quantity;
        if ($result < 0) {
            Flasher::addWarning("No puede generar existencia negativa al eliminar la entrada");
            return back();
        }

        try {
            DB::beginTransaction();
            $inventory->project->actual_capacity = $result;
            $inventory->project->percentage = $this->calculatePercentage($inventory->project);
            $inventory->project->save();

            $inventory->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            abort(403, $e->getMessage());
        }

        Flasher::addInfo('El registro ha sido eliminado de la base de datos.');
        return redirect()->route('inventories.index');
    }
}
