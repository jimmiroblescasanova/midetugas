<?php

namespace App\Http\Controllers;

use App\Clients;
use Illuminate\Http\Request;

class DocumentsController extends Controller
{
    public function create()
    {
        return view('documents.create', [
            'clients' => Clients::select('id', 'name', 'account_number')->where('measurer_id', !NULL)->get(),
        ]);
    }
}
