<?php

namespace App\Http\Livewire\Payments;

use App\Payment;
use App\Document;
use Livewire\Component;

class EditPayment extends Component
{
    public Payment $payment;

    public $usingBalance = false;
    public $payAmount = 0;
    public $totalPaid = 0;
    public $pendingPaid = 0;

    protected $listeners = [
        'emitPay' => 'addPay',
        'emitClosePayment' => 'closePayment',
    ];

    public function mount()
    {
        $this->usingBalance = $this->payment->balance == 0 ? false : true;
        $this->payAmount = round($this->payment->amount + $this->payment->balance, 2);
    }

    public function updatedUsingBalance()
    {
        if ($this->usingBalance === false && ($this->totalPaid > $this->payment->amount)) {
            flash()->addError('El importe abonado es mayor al total.');
            $this->usingBalance = true;
            return false;
        }
        if ($this->usingBalance === true) {
            $this->payment->update([
                'balance' => $this->payment->client->balance,
            ]);
            $this->payment->client->update([
                'balance' => 0,
            ]);
        } else {
            $this->payment->client->update([
                'balance' => $this->payment->balance,
            ]);
            $this->payment->update([
                'balance' => 0,
            ]);
        }

        $this->payAmount = round($this->payment->amount + $this->payment->balance, 2);
    }

    public function addPay($id, $amount)
    {
        $document = Document::find($id);

        if ($amount > $this->pendingPaid) {
            flash()->addError("Solo puedes abonar máximo: $ {$this->pendingPaid}");

            $this->emit('closeModal');
            return false;
        } elseif ($document->pending < $amount) {
            flash()->addError('El abono no puede ser mayor al saldo.');

            $this->emit('closeModal');
            return false;
        }

        $document->update([
            'pending' => $document->pending - $amount,
        ]);

        $this->payment->documents()->attach($document, [
            'amount' => $amount * 100,
        ]);

        $this->totalPaid += $amount;

        $this->emit('closeModal');
    }

    public function deletePay($id)
    {
        // encuentra el documento asociado
        $document = Document::findOrFail($id);
        // obtenemos el importe pagado
        $amount = $this->payment->documents->find($id)->pivot->amount;
        // actualizamos el documento sumando el pago
        $document->update([
            'pending' => $document->pending + $amount,
        ]);
        // por ultimo eliminamos el pago
        $this->payment->documents()->detach($id);

        flash()->addSuccess('El abono ha sido eliminado.');
    }

    public function closePayment()
    {
        // actualizamos por ultima vez el saldo del cliente con el pendiente
        $this->payment->client->update([
            'balance' => $this->pendingPaid + $this->payment->client->balance,
        ]);
        // cerramos el pago
        $this->payment->update([
            'closed' => true,
        ]);

        flash()->addSuccess('El pago ha sido guardado con éxito.');
        return redirect()->route('payments.index');
    }

    public function setAmounts()
    {
        $this->totalPaid = round($this->payment->documents()->sum('amount') / 100, 2);

        $this->pendingPaid = round($this->payAmount - $this->totalPaid, 2);
    }

    public function render()
    {
        // recarga los importes 
        $this->setAmounts();
        // obtenemos los pagos en la tabla pivot
        $pays = $this->payment->documents()->get();
        // carga los documentos pendientes de asociar
        $documents = Document::query()
        ->where([
            ['client_id', $this->payment->client->id],
            ['status', 2],
            ['pending', '>=', 0.01],
        ])
        ->whereNotIn('id', $pays->pluck('id'))
        ->get();

        return view('livewire.payments.edit-payment', [
            'documents' => $documents,
            'pays' => $pays,
        ]);
    }
}
