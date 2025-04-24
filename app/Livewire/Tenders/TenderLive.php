<?php

namespace App\Livewire\Tenders;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use App\Models\Tender;
use Livewire\WithPagination;

class TenderLive extends Component
{
    use LivewireAlert, WithPagination;

    public $modal = false;
    public $id, $search;
    public $title, $description, $deadline, $status;

    protected $rules = [
        'title' => 'required|min:5|max:255',
        'description' => 'required|string',
        'deadline' => 'required|date|after:today',
        'status' => 'required|in:open,closed,evaluating,awarded'
    ];

    public function create($id = null){
        $this->id = $id;
        if($id){
            $tender = Tender::find($id);
            $this->fill($tender->toArray());
        } else {
            $this->reset(['title', 'description', 'deadline', 'status']);
        }
        $this->modal = true;
    }

    public function delete($id){
        Tender::find($id)->delete();
        $this->alert('success', 'Tender deleted successfully!');
    }

    public function store(){
        $this->validate();

        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'deadline' => $this->deadline,
            'status' => $this->status
        ];

        if($this->id) {
            Tender::find($this->id)->update($data);
            $message = 'Tender updated successfully!';
        } else {
            Tender::create($data);
            $message = 'Tender created successfully!';
        }

        $this->cancel();
        $this->alert('success', $message);
    }

    public function cancel(){
        $this->reset(['modal', 'id', 'title', 'description', 'deadline', 'status']);
        $this->dispatch('modal-cancel');
    }

    public function render()
    {
        $tenders = Tender::when($this->search, function($query) {
                return $query->where('title', 'like', '%'.$this->search.'%')
                             ->orWhere('description', 'like', '%'.$this->search.'%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.tenders.tender-live', compact('tenders'));
    }
}
