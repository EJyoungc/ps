<?php

namespace App\Livewire\Suppliers;

use App\Models\Supplier;
use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class SupplierLive extends Component
{
    use LivewireAlert;

    public $modal = false;
    public $confirmModal = false;
    public $id;
    public $user_id;
    public $company_name;
    public $contact_person;
    public $phone;
    public $address;
    public $status = 'pending';
    public $search;
    public $suppliers = [];
    public $users = [];

    protected $rules = [
        'user_id' => 'required|exists:users,id',
        'company_name' => 'required|string|max:255',
        'contact_person' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        'address' => 'required|string',
        'status' => 'required|in:pending,approved,rejected'
    ];

    public function create($id = null)
    {
        $this->id = $id;
        if ($id) {
            $supplier = Supplier::findOrFail($id);
            $this->user_id = $supplier->user_id;
            $this->company_name = $supplier->company_name;
            $this->contact_person = $supplier->contact_person;
            $this->phone = $supplier->phone;
            $this->address = $supplier->address;
            $this->status = $supplier->status;
        } else {
            $this->reset(['user_id', 'company_name', 'contact_person', 'phone', 'address', 'status']);
        }
        $this->modal = true;
    }

    public function delete($id)
    {
        Supplier::findOrFail($id)->delete();
        $this->alert('success', 'Supplier deleted successfully!');
        $this->cancel();
    }

    public function confirmDelete($id)
    {
        $this->confirm('Are you sure?', [
            'text' => 'You won\'t be able to revert this!',
            'showConfirmButton' => true,
            'confirmButtonText' => 'Yes, delete it!',
            'onConfirmed' => 'delete',
            'inputAttributes' => ['id' => $id],
        ]);
    }

    public function update()
    {
        $this->validate();

        $supplier = Supplier::findOrFail($this->id);
        $supplier->update([
            'user_id' => $this->user_id,
            'company_name' => $this->company_name,
            'contact_person' => $this->contact_person,
            'phone' => $this->phone,
            'address' => $this->address,
            'status' => $this->status
        ]);

        $this->alert('success', 'Supplier updated successfully!');
        $this->cancel();
    }

    public function store()
    {
        $this->validate();

        Supplier::create([
            'user_id' => $this->user_id,
            'company_name' => $this->company_name,
            'contact_person' => $this->contact_person,
            'phone' => $this->phone,
            'address' => $this->address,
            'status' => $this->status
        ]);

        $this->alert('success', 'Supplier created successfully!');
        $this->cancel();
    }

    public function cancel()
    {
        $this->reset(["modal", "id", "user_id", "company_name", "contact_person", "phone", "address", "status"]);
        $this->dispatch('modal-cancel');
    }

    public function render()
    {
        $this->users = User::all();
        $this->suppliers = Supplier::with('user')
            ->when($this->search, function ($query) {
                return $query->where('company_name', 'like', '%' . $this->search . '%')
                    ->orWhere('contact_person', 'like', '%' . $this->search . '%')
                    ->orWhere('phone', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->get();

        return view('livewire.suppliers.supplier-live');
    }
}
