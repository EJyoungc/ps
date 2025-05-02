<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ChecksupplierLive extends Component
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

    public function check(){
        // $user = User::find(Auth::user()->id);
        // // dd($user->supplier_id);
        // if( Auth::user()->hasRole('supplier') && empty($user->supplier_id)) {
        //     // User is a supplier and has a supplier ID
        //    return redirect()->route('check.supplier');
        // }else{
        //     return redirect()->route('dashboard');
        // }
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

    public function render()
    {
        return view('livewire.checksupplier-live');
    }
}
