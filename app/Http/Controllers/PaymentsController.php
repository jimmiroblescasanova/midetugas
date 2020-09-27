<?php

namespace App\Http\Controllers;

use App\Payment;
use App\Document;
use App\Http\Requests\SavePaymentRequest;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('payments.index', [
            'payments' => Payment::orderByDesc('id')->get(),
        ]);
    }

    public function store(SavePaymentRequest $request)
    {
        $docto = Document::findOrFail($request->document_id);
        $diff = $docto->pending - $request->amount;

        if ($diff < 0)
        {
            return redirect()->back()
                ->with('message', 'No se puede aplicar una cantidad mayor al importe pendiente');
        }

        $docto->pending = $diff;
        $docto->status = 4;
        $docto->save();
        Payment::create($request->validated());

        return redirect()->route('documents.index');
    }
}
