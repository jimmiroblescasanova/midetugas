<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;
use Flasher\Laravel\Facade\Flasher;

class ProjectsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('projects.index', [
            'projects' => Project::all(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|min:5',
            'reference' => 'nullable|string',
        ]);

        $project = Project::create($data);

        if ($project instanceof Project) {
            Flasher::addSuccess('El registro ha sido guardado con éxito');
            return redirect()->route('projects.index', '#');
        }

        Flasher::addError('Ha ocurrido un error, intenta de nuevo');
        return redirect()->back();
    }

    public function edit(Project $project)
    {
        return view('projects.edit', [
            'project' => $project,
        ]);
    }

    public function update(Project $project, Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|min:5',
            'reference' => 'nullable|string',
        ]);

        $project->update($data);

        Flasher::addSuccess('El registro ha sido guardado con éxito');
        return redirect()->route('projects.index');
    }

    public function destroy(Project $project)
    {
        if ($project->tanks()->exists() || $project->clients()->exists() || $project->inventories()->exists()) {
            Flasher::addError('El registro no se ha podido eliminar, valida que no tenga información asociada.');
            return redirect()->back();
        }

        $project->delete();

        Flasher::addInfo('El registro ha sido eliminado con éxito');
        return redirect()->route('projects.index');
    }
}
