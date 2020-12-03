<?php

namespace App\Http\Controllers;

use App\Clients;
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
        $docto = Document::findOrFail($request['document_id']);
        $client = Clients::findOrFail($request['client_id']);

        $total = $request['amount'];

        if (isset($request['advancePaymentCheck']))
        {
            $total += $client->advance_payment;
        }

        if ($docto->pending > $total) {
            $docto->update([
                'pending' => $total,
                'status' => 4,
            ]);
        } else {
            $diff = $total - $docto->pending;

            $docto->update([
                'pending' => 0,
                'status' => 4,
            ]);

            if (isset($request['advancePaymentCheck']))
            {
                $client->update([
                    'advance_payment' => $diff,
                ]);
            } else {
                $new_total = $diff + $client->advance_payment;
                $client->update([
                    'advance_payment' => $new_total,
                ]);
            }
        }

        Payment::create($request->except('advancePaymentCheck'));

        return redirect()->route('documents.index');
    }
}
