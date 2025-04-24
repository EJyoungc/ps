<div>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Purchase Orders</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Purchase Orders</li>
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
                        <input type="text" wire:model.debounce.300ms="search" placeholder="Search orders..." class="form-control w-25" />
                        <button wire:click="create" class="btn btn-primary btn-sm">Add PO <x-spinner for="create" /></button>
                    </div>

                    <x-modal title="{{empty($poId) ? 'Edit Purchase Order' : 'Create Purchase Order' }}" :status="$modal">
                        <form wire:submit.prevent="{{ $poId ? 'update' : 'store' }}">
                            <div class="form-group">
                                <label for="purchase_request_id">Purchase Request</label>
                                <select wire:model="purchase_request_id" id="purchase_request_id" class="form-control">
                                    <option value="">-- Select Request --</option>
                                    @foreach($requests as  $item)
                                    <option value="{{ $item->id}}"> PR#{{ $item->id }} : {{ $item->department->name }} - {{ $item->items }} ({{ $item->user->name }})</option>
                                    @endforeach
                                </select>
                                @error('purchase_request_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label for="supplier_id">Supplier</label>
                                <select wire:model="supplier_id" id="supplier_id" class="form-control">
                                    <option value="">-- Select Supplier --</option>
                                    @foreach($suppliers as $id => $name)
                                        <option value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                                @error('supplier_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label for="po_number">PO Number</label>
                                <input wire:model="po_number" type="text" id="po_number" class="form-control" />
                                @error('po_number') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label for="delivery_date">Delivery Date</label>
                                <input wire:model="delivery_date" type="date" id="delivery_date" class="form-control" />
                                @error('delivery_date') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select wire:model="status" id="status" class="form-control">
                                    <option value="draft">Draft</option>
                                    <option value="issued">Issued</option>
                                    <option value="acknowledged">Acknowledged</option>
                                    <option value="fulfilled">Fulfilled</option>
                                </select>
                                @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="button" wire:click="cancel" class="btn btn-secondary mr-2">Cancel</button>
                                <button type="submit" class="btn btn-dark">{{ $poId ? 'Update' : 'Save' }} <x-spinner for="{{ $poId ? 'update' : 'store' }}" /></button>
                            </div>
                        </form>
                    </x-modal>

                    <div class="card">
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>PR#</th>
                                        <th>Supplier</th>
                                        <th>PO Number</th>
                                        <th>Delivery Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($orders as $order)
                                        <tr>
                                            <td>{{ $order->id }}</td>
                                            <td>{{ $order->purchaseRequest->id }}</td>
                                            <td>{{ $order->supplier->company_name }}</td>
                                            <td>{{ $order->po_number }}</td>
                                            <td>{{ $order->delivery_date->format('Y-m-d') }}</td>
                                            <td>{{ ucfirst(str_replace('_',' ',$order->status)) }}</td>
                                            <td>
                                                <button wire:click="create({{ $order->id }})" class="btn btn-sm btn-info">Edit</button>
                                                <button wire:click="delete({{ $order->id }})" class="btn btn-sm btn-danger">Delete</button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">No purchase orders found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mt-3">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
