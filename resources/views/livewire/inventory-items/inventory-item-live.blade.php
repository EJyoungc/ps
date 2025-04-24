<div>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Inventory Items</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Inventory</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between mb-3">
                        <input type="text" wire:model.debounce.300ms="search" placeholder="Search items..." class="form-control w-25" />
                        <button wire:click="create" class="btn btn-primary btn-sm">Add Item <x-spinner for="create" /></button>
                    </div>

                    <x-modal title="{{ $itemId ? 'Edit Item' : 'Add Item' }}" :status="$modal">
                        <form wire:submit.prevent="{{ $itemId ? 'update' : 'store' }}">
                            <div class="form-group">
                                <label>Name</label>
                                <input wire:model="name" type="text" class="form-control" />
                                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea wire:model="description" class="form-control" rows="3"></textarea>
                                @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label>Current Stock</label>
                                    <input wire:model="current_stock" type="number" class="form-control" />
                                    @error('current_stock') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Minimum Stock</label>
                                    <input wire:model="minimum_stock" type="number" class="form-control" />
                                    @error('minimum_stock') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Unit of Measure</label>
                                    <input wire:model="unit_of_measure" type="text" class="form-control" />
                                    @error('unit_of_measure') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="button" wire:click="cancel" class="btn btn-secondary mr-2">Cancel</button>
                                <button type="submit" class="btn btn-dark">{{ $itemId ? 'Update' : 'Save' }} <x-spinner for="{{ $itemId ? 'update' : 'store' }}" /></button>
                            </div>
                        </form>
                    </x-modal>

                    <div class="card">
                        <div class="card-body table-responsive p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Current</th>
                                        <th>Minimum</th>
                                        <th>Unit</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($items as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->current_stock }}</td>
                                            <td>{{ $item->minimum_stock }}</td>
                                            <td>{{ $item->unit_of_measure }}</td>
                                            <td>
                                                <button wire:click="create({{ $item->id }})" class="btn btn-sm btn-info">Edit</button>
                                                <button wire:click="delete({{ $item->id }})" class="btn btn-sm btn-danger">Delete</button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No items found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            {{ $items->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
