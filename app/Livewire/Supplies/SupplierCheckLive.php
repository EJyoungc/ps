<?php

namespace App\Livewire\Supplies;

use App\Models\Supplier;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component; use App\Services\NS;

class SupplierCheckLive extends Component
{
    use LivewireAlert;

    public $modal = false;
    public $search = "";
    public $organization;
    public $company_name;
    public $contact_person;
    public $phone;
    public $address;
    public $liststatus = false;
    public $organizations = [];
    public $user;

    protected $rules = [
        'company_name'   => 'required|string|max:255',
        'contact_person' => 'required|string|max:255',
        'phone'          => 'required|string|min:8',
        'address'        => 'required|string|max:500',
    ];

    public function mount()
    {
        $this->user = Auth::user();
        if (empty($this->user->supplier_id)) {


            $this->organization = Supplier::find($this->user->supplier_id);

        }
    }

    public function create($id = null)
    {
        $this->resetValidation();
        $this->reset(['company_name', 'contact_person', 'phone', 'address']);
        $this->modal = true;
    }

    public function store()
    {
        $this->validate();

        $supplier = Supplier::create([
            'user_id'        => Auth::id(),
            'company_name'   => $this->company_name,
            'contact_person' => $this->contact_person,
            'phone'          => $this->phone,
            'address'        => $this->address,
            'status'         => 'pending',
        ]);

        // Assign to user
        $this->user->supplier_id = $supplier->id;
        $this->user->save();

        $this->organization = $supplier;
        $this->modal = false;

        $this->alert('success', 'Organization created and assigned to your account');
    }

    public function get_all_orgs()
    {
        $this->liststatus = !$this->liststatus;
        $this->search = '';
        $this->organizations = $this->liststatus
            ? Supplier::all()
            : [];
    }

    public function updatedSearch()
    {
        if (strlen($this->search) > 1) {
            $this->liststatus = false;
            $this->organizations = Supplier::where('company_name', 'like', '%' . $this->search . '%')
                ->limit(10)
                ->get();
        } else {
            $this->organizations = [];
        }
    }

    public function select_org($id)
    {
        $this->organization = Supplier::findOrFail($id);
        $this->search = '';
        $this->organizations = [];
        $this->liststatus = false;
    }

    public function remove_org()
    {
        $this->organization = null;
        $this->user->supplier_id = null;
        $this->user->save();
    }

    public function save()
    {
        if ($this->organization) {
            $this->user->supplier_id = $this->organization->id;
            $this->user->save();
            $this->alert('success', 'Organization successfully selected');
        }
    }

    public function cancel()
    {
        $this->reset(['modal', 'company_name', 'contact_person', 'phone', 'address']);
        $this->dispatch('modal-cancel');
    }

    public function render()
    {
        return view('livewire.supplies.supplier-check-live')
            ->layout('layouts.blank');
    }
}
