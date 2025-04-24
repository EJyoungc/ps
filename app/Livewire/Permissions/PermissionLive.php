<?php

namespace App\Livewire\Permissions;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

class PermissionLive extends Component
{
    use LivewireAlert;

    public $modal = false;
    public $confirmModal = false;
    public $name;
    public $selectedPermission;
    public $search;

    protected $rules = [
        'name' => 'required|string|unique:permissions,name'
    ];

    public function openModal()
    {
        $this->modal = true;
    }

    public function closeModal()
    {
        $this->modal = false;
        $this->reset(['name', 'selectedPermission']);
    }

    public function create()
    {
        $this->openModal();
    }

    public function edit(Permission $permission)
    {
        $this->selectedPermission = $permission;
        $this->name = $permission->name;
        $this->openModal();
    }

    public function delete(Permission $permission)
    {
        $permission->delete();
        $this->alert('success', 'Permission deleted successfully!');
        $this->closeModal();
    }

    public function confirmDelete(Permission $permission)
    {
        $this->selectedPermission = $permission;
        $this->confirmModal = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->selectedPermission) {
            $this->selectedPermission->update(['name' => $this->name]);
            $this->alert('success', 'Permission updated successfully!');
        } else {
            Permission::create(['name' => $this->name, 'guard_name' => 'web']);
            $this->alert('success', 'Permission created successfully!');
        }

        $this->closeModal();
    }

    public function render()
    {
        $permissions = Permission::when($this->search, function ($query) {
            return $query->where('name', 'like', '%' . $this->search . '%');
        })->get();

        return view('livewire.permissions.permission-live', compact('permissions'));
    }
}