<?php

namespace App\Http\Controllers;

use App\Tank;
use App\Project;
use Illuminate\Support\Facades\DB;
use App\Traits\UpdateProjectTrait;
use Flasher\Laravel\Facade\Flasher;
use App\Http\Requests\StoreTankRequest;

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
            'tank' => new Tank,
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
            $project['percentage'] = $this->calculatePercentage($project);
        }
        $project->save();

        Tank::create( $data );

        Flasher::addPreset('dbCreated');
        return redirect()->route('tanks.index');
    }

    public function edit(Tank $tank)
    {
        return view('tanks.edit', [
            'tank' => $tank,
            'projects' => Project::pluck('name', 'id'),
        ]);
    }

    public function update(Tank $tank, StoreTankRequest $request)
    {
        $suma_medidores = Tank::where([
            ['id', '!=', $tank->id],
            ['project_id', $tank->project_id],
            ])->sum('capacity');

        if ($tank->project->actual_capacity > ($suma_medidores + $request->capacity)) {
            Flasher::addError('La capacidad no puede ser menor que el inventario actual');
            return redirect()->back();
        }

        $tank->project->total_capacity = $suma_medidores + $request->capacity;
        $tank->project->percentage = $this->calculatePercentage($tank->project);
        $tank->project->save();

        $tank->update( $request->validated() );

        Flasher::addPreset('dbUpdated');
        return redirect()->route('tanks.index');
    }

    public function destroy(Tank $tank)
    {
        $capacidad_nueva = $tank->project->total_capacity - $tank->capacity;

        if ($capacidad_nueva < $tank->project->actual_capacity) {
            Flasher::addWarning('La capacidad total no puede ser menos a la actual');
            return redirect()->back();
        }

        try {
            DB::beginTransaction();
            // actualiza los valores antes de eliminar el registro
            $tank->project->total_capacity = $capacidad_nueva;
            $tank->project->percentage = $this->calculatePercentage($tank->project);
            $tank->project->save();
            // procede a eliminar el registro
            $tank->delete();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            Flasher::addWarning('No se pudo eliminar el registro.');
            return redirect()->back();
        }

        Flasher::addPreset('dbDeleted');
        return redirect()->route('tanks.index');
    }

}
