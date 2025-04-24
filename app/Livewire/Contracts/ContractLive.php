<?php

namespace App\Livewire\Contracts;

use App\Models\Contract;
use App\Models\PurchaseOrder;
use App\Models\Supplier;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class ContractLive extends Component
{
    use LivewireAlert, WithPagination;

    public $modal = false;
    public $contractId = null;
    public $purchase_order_id;
    public $supplier_id;
    public $start_date;
    public $end_date;
    public $terms;
    public $renewal_alert_sent = false;
    public $search = '';
    public $perPage = 10;

    protected $rules = [
        'purchase_order_id'   => 'required|exists:purchase_orders,id',
        'supplier_id'         => 'required|exists:suppliers,id',
        'start_date'          => 'required|date',
        'end_date'            => 'required|date|after_or_equal:start_date',
        'terms'               => 'required|string',
        'renewal_alert_sent'  => 'boolean',
    ];

    public function create($id = null)
    {
        $this->resetErrorBag();
        $this->resetValidation();

        if ($id) {
            $contract = Contract::findOrFail($id);
            $this->contractId = $contract->id;
            $this->purchase_order_id  = $contract->purchase_order_id;
            $this->supplier_id        = $contract->supplier_id;
            $this->start_date         = $contract->start_date->format('Y-m-d');
            $this->end_date           = $contract->end_date->format('Y-m-d');
            $this->terms              = $contract->terms;
            $this->renewal_alert_sent = $contract->renewal_alert_sent;
        } else {
            $this->contractId = null;
            $this->purchase_order_id = null;
            $this->supplier_id = null;
            $this->start_date = now()->format('Y-m-d');
            $this->end_date = now()->addYear()->format('Y-m-d');
            $this->terms = null;
            $this->renewal_alert_sent = false;
        }

        $this->modal = true;
    }

    public function store()
    {
        $this->validate();

        Contract::create([
            'purchase_order_id'   => $this->purchase_order_id,
            'supplier_id'         => $this->supplier_id,
            'start_date'          => $this->start_date,
            'end_date'            => $this->end_date,
            'terms'               => $this->terms,
            'renewal_alert_sent'  => $this->renewal_alert_sent,
        ]);

        $this->alert('success', 'Contract created successfully');
        $this->cancel();
    }

    public function update()
    {
        $this->validate();

        $contract = Contract::findOrFail($this->contractId);
        $contract->update([
            'purchase_order_id'   => $this->purchase_order_id,
            'supplier_id'         => $this->supplier_id,
            'start_date'          => $this->start_date,
            'end_date'            => $this->end_date,
            'terms'               => $this->terms,
            'renewal_alert_sent'  => $this->renewal_alert_sent,
        ]);

        $this->alert('success', 'Contract updated successfully');
        $this->cancel();
    }

    public function delete($id)
    {
        Contract::findOrFail($id)->delete();
        $this->alert('success', 'Contract deleted successfully');
    }

    public function cancel()
    {
        $this->reset(['modal','contractId','purchase_order_id','supplier_id','start_date','end_date','terms','renewal_alert_sent']);
        $this->dispatch('modal-cancel');
    }

    public function render()
    {
        $contracts = Contract::with(['purchaseOrder','supplier'])
            ->where(function($q) {
                $q->whereHas('supplier', function($q2) {
                        $q2->where('company_name','like','%'.$this->search.'%');
                    })
                  ->orWhereHas('purchaseOrder', function($q3) {
                        $q3->where('po_number','like','%'.$this->search.'%');
                    });
            })
            ->orderBy('created_at','desc')
            ->paginate($this->perPage);

        $orders = PurchaseOrder::get();
        $suppliers = Supplier::pluck('company_name','id');

        return view('livewire.contracts.contract-live', compact('contracts','orders','suppliers'));
    }
}
