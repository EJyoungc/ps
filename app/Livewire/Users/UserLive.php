<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserLive extends Component
{
    use LivewireAlert;

    public $modal_roles = false;
    public $modal = false;
    public $id;
    public $users;
    public $roles;
    public $permissions;
    public $selectedRoles = [];
    public $selectedPermissions = [];
    public $selectedUser;

    // form

    public $name,
        $email,
        $password = "root";



    public function create($id = null)
    {
        if (empty($id)) {
            $this->modal = true;
        } else {
            $this->selectedUser = User::findOrFail($id);
            $this->name = $this->selectedUser->name;
            $this->email = $this->selectedUser->email;

        }
    }


    public function store()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'
        ]);

        if (empty($this->selectedUser)) {
            $this->selectedUser = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
            ]);
            $this->alert('success', 'User created/updated successfully.');
        } else {
            $this->selectedUser->update([
                'name' => $this->name,
                'email' => $this->email,
            ]);
            $this->alert('success', 'User updated successfully.');
        }



        $this->cancel();
    }


    public function update_roles_permissions($id)
    {
        $this->id = $id;
        if ($id) {
            $this->selectedUser = User::findOrFail($id);
            $this->selectedRoles = $this->selectedUser->roles->pluck('name')->toArray();
            $this->selectedPermissions = $this->selectedUser->permissions->pluck('name')->toArray();
        } else {
            $this->selectedUser = null;
            $this->selectedRoles = [];
            $this->selectedPermissions = [];
        }
        $this->modal_roles = true;
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        $this->alert('success', 'User deleted successfully.');
    }

    public function confirmDelete($id)
    {
        $this->confirm('Are you sure you want to delete this user?', [
            'onConfirmed' => 'delete',
            'params' => $id,
        ]);
    }

    public function update()
    {
        if ($this->id) {
            $user = User::findOrFail($this->id);
            $user->syncRoles($this->selectedRoles);
            $user->syncPermissions($this->selectedPermissions);
            $this->alert('success', 'User permissions updated successfully.');
            $this->cancel();
        }
    }

    public function cancel()
    {
        $this->reset(["modal_roles", "id", "selectedRoles", "selectedPermissions", "selectedUser", "name", "email", "password","modal"]);
        $this->dispatch('modal-cancel');
    }

    public function render()
    {
        $this->users = User::all();
        $this->roles = Role::all();
        $this->permissions = Permission::all();

        return view('livewire.users.user-live');
    }
}
