<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

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

        Project::create($data);

        Alert::success('Correcto', 'El registro ha sido creado con éxito.');
        return redirect()->route('projects.index');
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

        Alert::success('Actualizado', 'Registro actualizado correctamente');
        return redirect()->route('projects.index');
    }

    public function destroy(Project $project)
    {
        if ($project->tanks()->exists() || $project->clients()->exists() || $project->inventories()->exists()) {
            Alert::error('Error', 'El registro no se ha podido eliminar, valida que no tenga información asociada.');
            return redirect()->back();
        }

        $project->delete();

        Alert::success('Hecho', 'El registro ha sido eliminado con éxito de la base de datos.');
        return redirect()->route('projects.index');
    }
}
