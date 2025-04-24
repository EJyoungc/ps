<?php

namespace App\Livewire\Departments;

use App\Models\Department;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class DepartmentLive extends Component
{
    use LivewireAlert;

    public $modal = false;
    public $confirmModal = false;
    public $id;
    public $name;
    public $description;
    public $search;
    public $departments = [];

    protected $rules = [
        'name' => 'required|string|max:255|unique:departments,name',
        'description' => 'nullable|string'
    ];

    public function create($id = null)
    {
        $this->id = $id;
        if ($id) {
            $department = Department::findOrFail($id);
            $this->name = $department->name;
            $this->description = $department->description;
        } else {
            $this->reset(['name', 'description']);
        }
        $this->modal = true;
    }

    public function delete($id)
    {
        Department::findOrFail($id)->delete();
        $this->alert('success', 'Department deleted successfully!');
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
        $this->validate([
            'name' => 'required|string|max:255|unique:departments,name,' . $this->id,
            'description' => 'nullable|string'
        ]);

        $department = Department::findOrFail($this->id);
        $department->update([
            'name' => $this->name,
            'description' => $this->description
        ]);

        $this->alert('success', 'Department updated successfully!');
        $this->cancel();
    }

    public function store()
    {
        $this->validate();

        Department::create([
            'name' => $this->name,
            'description' => $this->description
        ]);

        $this->alert('success', 'Department created successfully!');
        $this->cancel();
    }

    public function cancel()
    {
        $this->reset(["modal", "id", "name", "description"]);
        $this->dispatch('modal-cancel');
    }

    public function render()
    {
        $this->departments = Department::when($this->search, function ($query) {
            return $query->where('name', 'like', '%' . $this->search . '%');
        })->latest()->get();

        return view('livewire.departments.department-live');
    }
}
