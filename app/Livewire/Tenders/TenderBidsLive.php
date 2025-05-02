<?php

namespace App\Livewire\Tenders;

use App\Mail\mailBid;
use App\Mail\SendBidENotification;
use App\Models\Bid;
use App\Models\Tender;
use Illuminate\Support\Facades\Mail;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class TenderBidsLive extends Component
{
    use LivewireAlert;
    public $modal = false;
    public $id;
    public $tender_id;
    public $tender;

    public function mount($id){
        $this->tender_id = $id;
        $this->tender = Tender::find($this->tender_id);

    }

    public function create($id = null){
        $this->id = $id;
        if($id){
            $this->modal = true;
        }else{
            $this->modal = true;
        }
    }


    public function delete($id){

    }

    public function update(){

    }

    public function status_update($id, $status){

        $bid = Bid::findOrFail($id);
        switch ($status) {
            case 'accepted':
                // dd($bid);
                $bids = Bid::where('tender_id', $this->tender_id)->get();
                $bids->each(function ($bid) {
                    $bid->update(['status' => 'rejected']);
                });
                $tender = Tender::find($this->tender_id);
                $bid->update(['status' => 'accepted']);
                $this->tender->update(['status' => 'awarded']);
                Mail::to($bid->supplier->user->email)->send(new mailBid($bid->supplier->user->name,$bid->supplier->user->email,$bid,$tender));
                $this->alert('success', 'Bid approved successfully!');
                break;
            case 'rejected':
                $bid->update(['status' => 'rejected']);
                $this->alert('success', 'Bid rejected successfully!');
                break;
            case 'under_review':
                $bid->update(['status' => 'under review']);
                $this->alert('info', 'Bid is under review!');
                break;
            default:
                $this->alert('error', 'Invalid status!');
        }

    }



    public function store(){
        $this->validate([

        ]);
    }

    public function cancel(){
        $this->reset(["modal","id"]);
        $this->dispatch('modal-cancel');
    }

    public function render()
    {
        $bids = Bid::where('tender_id', $this->tender_id)->orderBy('amount', 'asc')->get();
        return view('livewire.tenders.tender-bids-live')->with('bids', $bids);
    }
}
