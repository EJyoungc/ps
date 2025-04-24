<?php

namespace App\Livewire\PurchaseRequests;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use App\Models\PurchaseRequest;
use App\Models\User;
use App\Models\Department;

class PurchaseRequestLive extends Component
{
    use LivewireAlert;

    public $modal = false;
    public $id;
    public $search;
    public $user_id, $department_id, $items, $specifications, $estimated_cost, $status;

    protected $rules = [
        'user_id' => 'required|exists:users,id',
        'department_id' => 'required|exists:departments,id',
        'items' => 'required|string',
        'specifications' => 'required|string',
        'estimated_cost' => 'required|numeric|min:0',
        'status' => 'required|in:draft,submitted,approved,rejected,completed'
    ];

    public function create($id = null){
        $this->id = $id;
        if($id){
            $request = PurchaseRequest::find($id);
            $this->fill($request->toArray());
        }
        $this->modal = true;
    }

    public function delete($id){
        PurchaseRequest::find($id)->delete();
        $this->alert('success', 'Request deleted!');
    }

    public function store(){
        $this->validate();

        $data = [
            'user_id' => $this->user_id,
            'department_id' => $this->department_id,
            'items' => $this->items,
            'specifications' => $this->specifications,
            'estimated_cost' => $this->estimated_cost,
            'status' => $this->status
        ];

        if($this->id) {
            PurchaseRequest::find($this->id)->update($data);
            $this->alert('success', 'Request updated!');
        } else {
            PurchaseRequest::create($data);
            $this->alert('success', 'Request created!');
        }
        $this->cancel();
    }

    public function cancel(){
        $this->reset(["modal", "id", "user_id", "department_id", "items", "specifications", "estimated_cost", "status"]);
        $this->dispatch('modal-cancel');
    }

    public function render()
    {
        $requests = PurchaseRequest::with(['user', 'department'])
            ->when($this->search, fn($q) => $q->where('items', 'like', "%{$this->search}%"))
            ->latest()
            ->paginate(10);

        return view('livewire.purchase-requests.purchase-request-live', [
            'requests' => $requests,
            'users' => User::all(),
            'departments' => Department::all()
        ]);
    }
}
