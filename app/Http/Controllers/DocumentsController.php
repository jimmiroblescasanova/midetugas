<?php

namespace App\Http\Controllers;

use App\Clients;
use App\Document;
use App\Measurer;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DocumentsController extends Controller
{
    public function index()
    {
        return view('documents.index',[
            'documents' => Document::all(),
        ]);
    }

    public function create()
    {
        return view('documents.create', [
            'clients' => Clients::select('id', 'name', 'account_number')->whereNotNull('measurer_id')->get(),
        ]);
    }

    public function store(Request $request)
    {
        // Se obtiene el cliente capturado
        $client = Clients::findOrFail($request->client_id);
        // Se calcula el día de pago a partir de la fecha de captura
        $payment_date = Carbon::create($request->date)->addDays(20);
        // Guarda la foto y asigna la ruta
        $photo = $request->file('photo')->store('images');
        // Consumo del mes
        $month_quantity = $request->final_quantity - $client->measurer->actual_measure;
        // Importe total del mes
        $total = $month_quantity * 2.5;
        // Guarda todos los calores en un array
        $data = [
            'client_id' => $request->client_id,
            'date' => $request->date,
            'payment_date' => $payment_date,
            'final_quantity' => $request->final_quantity,
            'start_quantity' => $client->measurer->actual_measure,
            'month_quantity' => $month_quantity,
            'photo' => $photo,
            'total' => $total,
            'pending' => $total,
        ];
        // Crea el documento a partir de array
        Document::create($data);
        // Obtener el id del medidor usado y actualiza su valor
        $measurer = Measurer::findOrFail($client->measurer->id);
        $measurer->actual_measure = $request->final_quantity;
        $measurer->save();

        return redirect()->route('documents.create');
    }
}
