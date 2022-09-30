<?php

namespace App\Http\Controllers;

use App\Client;
use App\Payment;
use App\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\SavePaymentRequest;
use App\Http\Requests\CreatePaymentRequest;

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
        $paymentData = [
            'client_id' => $request->client,
            'amount' => $request->total,
            'date' => $request->date,
        ];

        try {
            DB::beginTransaction();
            $pay = Payment::create($paymentData);

            $client = Client::findOrFail($request->client);
            if (array_key_exists('useBalance', $request->toArray())) {
                $client->balance = $request->pending;
            } else {
                $client->balance = $client->balance + $request->pending;
            }
            $client->save();

            foreach ($request->pay as $id => $value) {
                if (!is_null($value)) {
                    $document = Document::findOrFail($id);
                    $document->pending = $document->pending - $value;
                    $document->save();

                    $pay->documents()->attach($id, [
                        'amount' => $value * 100,
                    ]);
                }
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            abort(403, $th->getMessage());
        }

        return redirect()->route('payments.index');
    }

    function show(Payment $payment)
    {
        return view('payments.show', [
            'payment' => $payment,
        ]);
    }

    public function destroy(Payment $payment)
    {
        try {
            DB::beginTransaction();

            foreach ($payment->documents as $document) {
                $document->pending += $document->pivot->amount;
                $document->save();
            }

            $payment->documents()->detach();
            $payment->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            abort(500, $e->getMessage());
        }

        Alert::info('Eliminado', 'Registro eliminado correctamente.');
        return redirect()->route('documents.index');
    }
}
