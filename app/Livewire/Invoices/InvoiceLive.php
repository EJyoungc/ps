<?php

namespace App\Livewire\Invoices;

use App\Models\Invoice;
use App\Models\PurchaseOrder;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class InvoiceLive extends Component
{
    use LivewireAlert, WithPagination;

    public $modal = false;
    public $id;
    public $purchase_order_id, $invoice_number, $amount, $due_date, $status;
    public $search = '';

    protected $rules = [
        'purchase_order_id' => 'required|exists:purchase_orders,id',
        'invoice_number' => 'required|string|unique:invoices,invoice_number',
        'amount' => 'required|numeric|min:0',
        'due_date' => 'required|date',
        'status' => 'required|in:pending,verified,paid,disputed',
    ];

    public function create($id = null){
        $this->resetValidation();
        $this->resetForm();
        $this->id = $id;

        if ($id) {
            $invoice = Invoice::findOrFail($id);
            $this->fill($invoice->toArray());
        }
        $this->modal = true;
    }

    public function store(){
        $this->validate();

        if ($this->id) {
            $invoice = Invoice::findOrFail($this->id);
            $invoice->update($this->formData());
            $this->alert('success', 'Invoice Updated Successfully');
        } else {
            Invoice::create($this->formData());
            $this->alert('success', 'Invoice Created Successfully');
        }

        $this->cancel();
    }

    public function delete($id){
        Invoice::findOrFail($id)->delete();
        $this->alert('success', 'Invoice Deleted Successfully');
    }

    public function cancel(){
        $this->reset(["modal", "id"]);
        $this->resetForm();
        $this->dispatch('modal-cancel');
    }

    private function formData(){
        return [
            'purchase_order_id' => $this->purchase_order_id,
            'invoice_number' => $this->invoice_number,
            'amount' => $this->amount,
            'due_date' => $this->due_date,
            'status' => $this->status,
        ];
    }

    private function resetForm(){
        $this->purchase_order_id = '';
        $this->invoice_number = '';
        $this->amount = '';
        $this->due_date = '';
        $this->status = '';
    }


    public function render()
    {
        $invoices = Invoice::where('invoice_number', 'like', '%'.$this->search.'%')
                            ->orWhere('amount', 'like', '%'.$this->search.'%')
                            ->latest()
                            ->paginate(10);

        $purchaseOrders = PurchaseOrder::all();

        return view('livewire.invoices.invoice-live', compact('invoices', 'purchaseOrders'));
    }
}
