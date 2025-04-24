<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class DashboardLive extends Component
{



    use LivewireAlert;
    public $modal = false;
    public $id;

    public function create($id = null){
        $this->id = $id;
        if($id){
            $this->modal = true;
        }else{
            $this->modal = true;
        }
    }

    public function assign(){
        $user  = User::find(Auth::user()->id);
        $user->assignRole('admin');
        $this->alert('success', 'Role assigned successfully');
    }

    public function delete($id){

    }

    public function update(){

    }

    public function store(){
        $this->validate([

        ]);
    }

    public function cancel(){
        $this->reset(["modal","id"]);
        $this->dispatch('modal-cancel');
    }

    public function test()
    {
        $this->alert('success', 'This is a success message');
        // dd('test');
    }

    public function render()
    {
        return view('livewire.dashboard-live');
    }
}
