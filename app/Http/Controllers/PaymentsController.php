<?php

namespace App\Http\Controllers;

use App\Client;
use App\Payment;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Flasher\Laravel\Facade\Flasher;

class PaymentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('payments.index', [
            'unclosedPayments' => Payment::where('closed', false)->count(),
            'projects' => Project::orderBy('name', 'asc')->pluck('name', 'id'),
        ]);
    }

    public function store(Request $request)
    {
        $paymentData = [
            'client_id' => $request->client,
            'amount' => $request->amount,
            'date' => $request->date,
        ];

        $pay = Payment::create($paymentData);

        return redirect()->route('payments.edit', $pay);
    }

    function show(Payment $payment)
    {
        return view('payments.show', [
            'payment' => $payment,
        ]);
    }

    function edit(Payment $payment)
    {
        return view('payments.edit', [
            'payment' => $payment,
        ]);
    }

    public function destroy(Payment $payment)
    {
        try {
            DB::beginTransaction();

            // obtenemos el pendiente 
            $amountUsed = $payment->documents()->sum('amount') / 100;
            // calculamos el pendiente del documento pago
            $pendingToPay = $payment->balance - (($payment->amount + $payment->balance) - $amountUsed);
            // actualizamos el saldo del cliente
            $payment->client->update([
                'balance' => $payment->client->balance + $pendingToPay,
            ]);
            // actualizamos todos los documentos, sumando el pago asociado
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

        Flasher::addInfo('Registro eliminado correctamente.');
        return redirect()->route('payments.index');
    }
}
