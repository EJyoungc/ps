<?php

// File: app/Livewire/Bids/MyBidsLive.php

namespace App\Livewire\Bids;

use App\Models\Tender;
use App\Models\Bid;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class MyBidsLive extends Component
{
    use LivewireAlert, WithPagination;

    public $modal = false;
    public $tenderId;
    public $amount;
    public $proposal;
    public $status = 'submitted';

    protected $rules = [
        'tenderId' => 'required|exists:tenders,id',
        'amount'   => 'required|numeric|min:0',
        'proposal' => 'required|string',
        'status'   => 'required|in:submitted,under_review,accepted,rejected',
    ];

    public function create($tenderId)
    {
        $this->reset(['amount','proposal','status']);
        $this->tenderId = $tenderId;
        $this->modal = true;
    }

    public function store()
    {
        $this->validate();

        Bid::updateOrCreate(
            ['tender_id' => $this->tenderId, 'supplier_id' => Auth::id()],
            ['amount' => $this->amount, 'proposal' => $this->proposal, 'status' => $this->status]
        );

        $this->alert('success', 'Your bid has been submitted.');
        $this->cancel();
    }

    public function cancel()
    {
        $this->reset(['modal','tenderId','amount','proposal','status']);
        $this->dispatch('modal-cancel');
    }

    public function render()
    {
        $supplierId = Auth::id();

        $tenders = Tender::where('status','open')->orderBy('deadline')->paginate(10);

        // Group bids by tender for this supplier
        $myBids = Bid::where('supplier_id', $supplierId)
            ->get()
            ->keyBy('tender_id');

        return view('livewire.bids.my-bids-live')->with('tenders', $tenders)
            ->with('myBids', $myBids);
    }
}
