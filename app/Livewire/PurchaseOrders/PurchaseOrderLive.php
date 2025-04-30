<?php

namespace App\Livewire\PurchaseOrders;

use App\Models\PurchaseOrder;
use App\Models\PurchaseRequest;
use App\Models\Supplier;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component; use App\Services\NS;
use Livewire\WithPagination;

class PurchaseOrderLive extends Component
{
    use LivewireAlert, WithPagination;

    public $modal = false;
    public $poId = null;
    public $purchase_request_id;
    public $supplier_id;
    public $po_number;
    public $delivery_date;
    public $status = 'draft';
    public $search = '';
    public $perPage = 10;

    protected $rules = [
        'purchase_request_id' => 'required|exists:purchase_requests,id',
        'supplier_id'         => 'required|exists:suppliers,id',
        'po_number'           => 'required|string|unique:purchase_orders,po_number',
        'delivery_date'       => 'required|date',
        'status'              => 'required|in:draft,issued,acknowledged,fulfilled',
    ];

    public function create($id = null)
    {
        $this->resetErrorBag();
        $this->resetValidation();

        if ($id) {
            $po = PurchaseOrder::findOrFail($id);
            $this->poId = $po->id;
            $this->purchase_request_id = $po->purchase_request_id;
            $this->supplier_id = $po->supplier_id;
            $this->po_number = $po->po_number;
            $this->delivery_date = $po->delivery_date->format('Y-m-d');
            $this->status = $po->status;
        } else {
            $this->poId = null;
            $this->purchase_request_id = null;
            $this->supplier_id = null;
            $this->po_number = null;
            $this->delivery_date = now()->format('Y-m-d');
            $this->status = 'draft';

        }

        $this->modal = true;
    }

    public function store()
    {
        $this->validate();

        PurchaseOrder::create([
            'purchase_request_id' => $this->purchase_request_id,
            'supplier_id'         => $this->supplier_id,
            'po_number'           => $this->po_number,
            'delivery_date'       => $this->delivery_date,
            'status'              => $this->status,
        ]);

        $this->alert('success', 'Purchase Order created successfully');
        NS::create( 'Purchase Order created', $this->po_number ,'Purchase Order with ID ' . $this->poId . ' has been created.');
        $this->cancel();
    }

    public function update()
    {
        $this->validate();

        $po = PurchaseOrder::findOrFail($this->poId);
        $po->update([
            'purchase_request_id' => $this->purchase_request_id,
            'supplier_id'         => $this->supplier_id,
            'po_number'           => $this->po_number,
            'delivery_date'       => $this->delivery_date,
            'status'              => $this->status,
        ]);

        $this->alert('success', 'Purchase Order updated successfully');
        NS::create( 'Purchase Order updated', $this->po_number, 'Purchase Order with ID ' . $this->poId . ' has been updated.', 'info');
        $this->cancel();
    }

    public function delete($id)
    {
        $po =PurchaseOrder::findOrFail($id)->delete();
        NS::create( 'Purchase Order deleted', $po ,'Purchase Order with ID ' . $po->id . ' has been deleted.');
        $this->alert('success', 'Purchase Order deleted successfully');
    }

    public function cancel()
    {
        $this->reset(['modal', 'poId', 'purchase_request_id', 'supplier_id', 'po_number', 'delivery_date', 'status']);
        $this->dispatch('modal-cancel');
    }

    public function render()
    {
        $orders = PurchaseOrder::with(['purchaseRequest', 'supplier'])
            ->where(function ($q) {
                $q->where('po_number', 'like', '%' . $this->search . '%')
                    ->orWhereHas('supplier', function ($q2) {
                        $q2->where('name', 'like', '%' . $this->search . '%');
                    });
                // ->orWhereHas('purchaseRequest', function ($q3) {
                //     $q3->where('title', 'like', '%' . $this->search . '%');
                // });
            })
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        $requests = PurchaseRequest::get();
        $suppliers = Supplier::pluck('company_name', 'id');

        return view('livewire.purchase-orders.purchase-order-live', compact('orders', 'requests', 'suppliers'));
    }
}
