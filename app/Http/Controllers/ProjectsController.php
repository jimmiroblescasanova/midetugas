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

        Project::create( $data );
        Alert::success('Correcto', 'Condominio creado correctamente');
        return redirect()->route('projects.index');
    }

}
