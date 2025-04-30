<?php

namespace App\Livewire\Payments;

use App\Models\Payment;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component; use App\Services\NS;

class PaymentLive extends Component
{
    use LivewireAlert;

    public $modal = false;
    public $id;
    public $invoice_id;
    public $amount;
    public $payment_date;
    public $reference_number;
    public $search = '';

    public function create($id = null)
    {
        $this->reset(['invoice_id', 'amount', 'payment_date', 'reference_number', 'id']);
        $this->id = $id;

        if ($id) {
            $payment = Payment::findOrFail($id);
            $this->invoice_id = $payment->invoice_id;
            $this->amount = $payment->amount;
            $this->payment_date = $payment->payment_date;
            $this->reference_number = $payment->reference_number;
        }

        $this->modal = true;
    }

    public function store()
    {
        $this->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'reference_number' => 'required|string|max:255',
        ]);

        if ($this->id) {
            $payment = Payment::findOrFail($this->id);
            $payment->update([
                'invoice_id' => $this->invoice_id,
                'amount' => $this->amount,
                'payment_date' => $this->payment_date,
                'reference_number' => $this->reference_number,
            ]);

            $this->alert('success', 'Payment updated successfully.');
        } else {
            Payment::create([
                'invoice_id' => $this->invoice_id,
                'amount' => $this->amount,
                'payment_date' => $this->payment_date,
                'reference_number' => $this->reference_number,
            ]);

            $this->alert('success', 'Payment created successfully.');
        }

        $this->cancel();
    }

    public function delete($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();

        $this->alert('success', 'Payment deleted successfully.');
    }

    public function cancel()
    {
        $this->reset(['modal', 'id', 'invoice_id', 'amount', 'payment_date', 'reference_number']);
        $this->dispatch('modal-cancel');
    }

    public function render()
    {
        $payments = Payment::where('reference_number', 'like', '%'.$this->search.'%')
                    ->orWhere('amount', 'like', '%'.$this->search.'%')
                    ->latest()
                    ->get();

        return view('livewire.payments.payment-live', [
            'payments' => $payments,
        ]);
    }
}
