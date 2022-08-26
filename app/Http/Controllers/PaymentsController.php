<?php

namespace App\Http\Controllers;

use App\Client;
use App\Payment;
use App\Document;
use App\Http\Requests\CreatePaymentRequest;
use App\Http\Requests\SavePaymentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            'clients' => Client::pluck('name', 'id'),
        ]);
    }

    public function createForm(CreatePaymentRequest $request)
    {
        return redirect()->route('payments.create', $request->client);
    }

    public function store(Request $request)
    {
        return $request;
    }

    public function destroy(Request $request)
    {
        $payment = Payment::findOrFail($request['id']);
        $document = Document::findOrFail($payment->document_id);

        try {
            DB::beginTransaction();
            $document->pending = $document->pending + $payment->amount;
            $document->status = 2;
            $document->save();
            $payment->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return $e;
        }

        return response()->json([
            'msg' => 'Eliminado correctamente',
        ], 200);
    }
}
