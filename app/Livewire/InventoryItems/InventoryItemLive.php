<?php

namespace App\Livewire\InventoryItems;

use App\Models\InventoryItem;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class InventoryItemLive extends Component
{
    use LivewireAlert, WithPagination;

    public $modal = false;
    public $itemId = null;
    public $name;
    public $description;
    public $current_stock;
    public $minimum_stock;
    public $unit_of_measure;
    public $search = '';
    public $perPage = 10;

    protected $rules = [
        'name'           => 'required|string|max:255',
        'description'    => 'nullable|string',
        'current_stock'  => 'required|integer|min:0',
        'minimum_stock'  => 'required|integer|min:0',
        'unit_of_measure'=> 'required|string|max:50',
    ];

    public function create($id = null)
    {
        $this->resetErrorBag();
        $this->resetValidation();

        if ($id) {
            $item = InventoryItem::findOrFail($id);
            $this->itemId         = $item->id;
            $this->name           = $item->name;
            $this->description    = $item->description;
            $this->current_stock  = $item->current_stock;
            $this->minimum_stock  = $item->minimum_stock;
            $this->unit_of_measure= $item->unit_of_measure;
        } else {
            $this->itemId          = null;
            $this->name            = '';
            $this->description     = '';
            $this->current_stock   = 0;
            $this->minimum_stock   = 0;
            $this->unit_of_measure = '';
        }

        $this->modal = true;
    }

    public function store()
    {
        $this->validate();

        InventoryItem::create([
            'name'            => $this->name,
            'description'     => $this->description,
            'current_stock'   => $this->current_stock,
            'minimum_stock'   => $this->minimum_stock,
            'unit_of_measure' => $this->unit_of_measure,
        ]);

        $this->alert('success', 'Item added successfully');
        $this->cancel();
    }

    public function update()
    {
        $this->validate();

        $item = InventoryItem::findOrFail($this->itemId);
        $item->update([
            'name'            => $this->name,
            'description'     => $this->description,
            'current_stock'   => $this->current_stock,
            'minimum_stock'   => $this->minimum_stock,
            'unit_of_measure' => $this->unit_of_measure,
        ]);

        $this->alert('success', 'Item updated successfully');
        $this->cancel();
    }

    public function delete($id)
    {
        InventoryItem::findOrFail($id)->delete();
        $this->alert('success', 'Item deleted successfully');
    }

    public function cancel()
    {
        $this->reset(['modal','itemId','name','description','current_stock','minimum_stock','unit_of_measure']);
        $this->dispatch('modal-cancel');
    }

    public function render()
    {
        $items = InventoryItem::where('name', 'like', '%'.$this->search.'%')
            ->orWhere('description', 'like', '%'.$this->search.'%')
            ->orderBy('created_at','desc')
            ->paginate($this->perPage);

        return view('livewire.inventory-items.inventory-item-live', compact('items'));
    }
}
