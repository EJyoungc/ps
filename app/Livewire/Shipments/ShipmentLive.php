<?php

namespace App\Livewire\Shipments;

use App\Models\Shipment;
use App\Models\PurchaseOrder;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ShipmentLive extends Component
{
    use LivewireAlert;

    public $modal = false;
    public $shipmentId;
    public $purchase_order_id, $expected_delivery_date, $actual_delivery_date, $status;

    public $statuses = ['pending', 'in_transit', 'delayed', 'delivered'];

    public function create($id = null)
    {
        $this->resetForm();

        if ($id) {
            $shipment = Shipment::findOrFail($id);
            $this->shipmentId = $shipment->id;
            $this->purchase_order_id = $shipment->purchase_order_id;
            $this->expected_delivery_date = $shipment->expected_delivery_date;
            $this->actual_delivery_date = $shipment->actual_delivery_date;
            $this->status = $shipment->status;
        }

        $this->modal = true;
    }

    public function store()
    {
        $validated = $this->validate([
            'purchase_order_id' => 'required|exists:purchase_orders,id',
            'expected_delivery_date' => 'required|date',
            'actual_delivery_date' => 'nullable|date',
            'status' => ['required', Rule::in($this->statuses)],
        ]);

        if ($this->shipmentId) {
            Shipment::findOrFail($this->shipmentId)->update($validated);
            $this->alert('success', 'Shipment updated successfully');
        } else {
            Shipment::create($validated);
            $this->alert('success', 'Shipment created successfully');
        }

        $this->resetForm();
        $this->dispatch('modal-close');
    }

    public function delete($id)
    {
        Shipment::findOrFail($id)->delete();
        $this->alert('success', 'Shipment deleted');
    }

    public function cancel()
    {
        $this->resetForm();
        $this->dispatch('modal-cancel');
    }

    private function resetForm()
    {
        $this->reset([
            'modal',
            'shipmentId',
            'purchase_order_id',
            'expected_delivery_date',
            'actual_delivery_date',
            'status'
        ]);
    }

    public function render()
    {
        return view('livewire.shipments.shipment-live', [
            'shipments' => Shipment::latest()->get(),
            'purchaseOrders' => PurchaseOrder::all(),
        ]);
    }
}
