<div>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Shipments</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Shipments</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-end mb-3">
                        <div class="form-group mr-2">
                            <input type="text" wire:model="search" placeholder="Search Shipments" class="form-control">
                        </div>
                        <div class="form-group">
                            <button @click="$wire.create(); $wire.dispatch('modal-open')" class="btn btn-primary btn-sm">
                                Add <x-spinner for="create" />
                            </button>
                        </div>
                    </div>

                    <x-modal title="{{ $shipmentId ? 'Edit Shipment' : 'Add Shipment' }}" :status="$modal">
                        <form wire:submit.prevent="store">
                            <div class="form-group">
                                <label for="purchase_order_id">Purchase Order</label>
                                <select wire:model="purchase_order_id" id="purchase_order_id" class="form-control">
                                    <option value="">-- Select Purchase Order --</option>
                                    @foreach($purchaseOrders as $order)
                                        <option value="{{ $order->id }}">PO #{{ $order->id }}</option>
                                    @endforeach
                                </select>
                                @error('purchase_order_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label for="expected_delivery_date">Expected Delivery Date</label>
                                <input type="date" wire:model="expected_delivery_date" id="expected_delivery_date" class="form-control">
                                @error('expected_delivery_date') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label for="actual_delivery_date">Actual Delivery Date</label>
                                <input type="date" wire:model="actual_delivery_date" id="actual_delivery_date" class="form-control">
                                @error('actual_delivery_date') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label for="status">Status</label>
                                <select wire:model="status" id="status" class="form-control">
                                    <option value="">-- Select Status --</option>
                                    @foreach($statuses as $stat)
                                        <option value="{{ $stat }}">{{ ucfirst(str_replace('_', ' ', $stat)) }}</option>
                                    @endforeach
                                </select>
                                @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group d-flex justify-content-end">
                                <button type="button" wire:click="cancel" class="btn btn-secondary mr-2">
                                    Cancel
                                </button>
                                <button type="submit" class="btn btn-dark">
                                    Save <x-spinner for="store" />
                                </button>
                            </div>
                        </form>
                    </x-modal>

                    <div class="card">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>PO ID</th>
                                            <th>Expected Date</th>
                                            <th>Actual Date</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($shipments as $shipment)
                                            <tr>
                                                <td>{{ $shipment->id }}</td>
                                                <td>{{ $shipment->purchase_order_id }}</td>
                                                <td>{{ $shipment->expected_delivery_date }}</td>
                                                <td>{{ $shipment->actual_delivery_date ?? 'N/A' }}</td>
                                                <td>{{ ucfirst(str_replace('_', ' ', $shipment->status)) }}</td>
                                                <td>
                                                    <button wire:click="create({{ $shipment->id }})" class="btn btn-info btn-sm">
                                                        Edit
                                                    </button>
                                                    <button wire:click="delete({{ $shipment->id }})" class="btn btn-danger btn-sm">
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No shipments found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>
