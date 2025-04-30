<?php

namespace App\Livewire\Bids;

use App\Models\Bid;
use App\Models\Tender;
use App\Models\Supplier;

use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component; use App\Services\NS;
use Livewire\WithPagination;

class BidLive extends Component
{
    use LivewireAlert, WithPagination;

    public $modal = false;
    public $bidId = null;
    public $tender_id;
    public $supplier_id;
    public $amount;
    public $proposal;
    public $status = 'submitted';
    public $search = '';
    public $perPage = 10;

    protected $rules = [
        'tender_id'   => 'required|exists:tenders,id',
        'supplier_id' => 'required|exists:suppliers,id',
        'amount'      => 'required|numeric|min:0',
        'proposal'    => 'required|string',
        'status'      => 'required|in:submitted,under_review,accepted,rejected',
    ];

    public function create($id = null)
    {
        $this->resetErrorBag();
        $this->resetValidation();

        if ($id) {
            // Edit existing bid
            $bid = Bid::findOrFail($id);
            $this->bidId       = $bid->id;
            $this->tender_id   = $bid->tender_id;
            $this->supplier_id = $bid->supplier_id;
            $this->amount      = $bid->amount;
            $this->proposal    = $bid->proposal;
            $this->status      = $bid->status;
        } else {
            // New bid
            $this->bidId = null;
            $this->tender_id = null;
            $this->supplier_id = null;
            $this->amount = null;
            $this->proposal = null;
            $this->status = 'submitted';
        }

        $this->modal = true;
    }

    public function store()
    {
        $this->validate();

        $Bid =Bid::create([
            'tender_id'   => $this->tender_id,
            'supplier_id' => $this->supplier_id,
            'amount'      => $this->amount,
            'proposal'    => $this->proposal,
            'status'      => $this->status,
        ]);

        $this->alert('success', 'Bid submitted successfully');
        NS::create('Bid created', $Bid ,'Bid with ID ' . $Bid->id . ' has been created.');
        $this->cancel();
    }

    public function update()
    {
        $this->validate();

        $bid = Bid::findOrFail($this->bidId);
        $bid->update([
            'tender_id'   => $this->tender_id,
            'supplier_id' => $this->supplier_id,
            'amount'      => $this->amount,
            'proposal'    => $this->proposal,
            'status'      => $this->status,
        ]);
        
        $this->alert('success', 'Bid updated successfully');
        NS::create($bid->user_id ,'Bid updated', $bid ,'Bid with ID ' . $this->bidId . ' has been updated.', Auth::id());
        $this->cancel();
    }

    public function delete($id)
    {
        $bid = Bid::findOrFail($id);

        NS::create('Bid deleted', $bid, 'Bid with ID ' . $id . ' has been deleted.', Auth::id());
        $bid->delete();
        
        $this->alert('success', 'Bid deleted successfully');
    }

    public function cancel()
    {
        $this->reset(['modal', 'bidId', 'tender_id', 'supplier_id', 'amount', 'proposal', 'status']);
        $this->dispatch('modal-cancel');
    }

    public function render()
    {
        $bids = Bid::with(['tender', 'supplier'])
            ->where(function($q) {
                $q->where('proposal', 'like', '%'.$this->search.'%')
                  ->orWhere('amount', 'like', '%'.$this->search.'%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        $tenders   = Tender::pluck('title', 'id');
        $suppliers = Supplier::pluck('company_name', 'id');

        return view('livewire.bids.bid-live', compact('bids', 'tenders', 'suppliers'));
    }
}
