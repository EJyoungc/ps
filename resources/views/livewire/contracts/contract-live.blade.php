<div>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Contracts</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Contracts</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-end mb-2">
                        <div class="form-group mr-2">
                            <input type="text" wire:model.debounce.300ms="search" placeholder="Search contracts..."
                                class="form-control">
                        </div>
                        <div class="form-group">
                            <button wire:click="create" class="btn btn-primary btn-sm">
                                Add Contract <x-spinner for="create" />
                            </button>
                        </div>
                    </div>

                    <x-modal title="Contract Form" :status="$modal">
                        <form wire:submit.prevent='store'>
                            <div class="form-group">
                                <label for="purchase_order_id">Purchase Order</label>
                                <select wire:model="purchase_order_id" class="form-control">
                                    <option value="">-- Select --</option>
                                    @foreach ($orders as $item)

                                        <option value="{{ $item->id }}">PO#{{ $item->po_number }}({{ $item->supplier->company_name }}) : {{ $item->purchaseRequest->department->name }} - {{ $item->purchaseRequest->items }}  </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="supplier_id">Supplier</label>
                                <select wire:model="supplier_id" class="form-control">
                                    <option value="">-- Select --</option>
                                    @foreach ($suppliers as $id => $name)
                                        <option value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Start Date</label>
                                <input type="date" wire:model="start_date" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>End Date</label>
                                <input type="date" wire:model="end_date" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Terms</label>
                                <textarea wire:model="terms" class="form-control" rows="4"></textarea>
                            </div>
                            <div class="form-check mb-2">
                                <input type="checkbox" wire:model="renewal_alert_sent" class="form-check-input"
                                    id="renewalAlert">
                                <label class="form-check-label" for="renewalAlert">Renewal Alert Sent</label>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-dark">Save <x-spinner for="store" /></button>
                                <button type="button" wire:click="cancel"
                                    class="btn btn-secondary ml-2">Cancel</button>
                            </div>
                        </form>
                    </x-modal>

                    <div class="card">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>PO</th>
                                            <th>Supplier</th>
                                            <th>Start</th>
                                            <th>End</th>
                                            <th>Alert Sent</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($contracts as $contract)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $contract->purchaseOrder->po_number ?? 'N/A' }}</td>
                                                <td>{{ $contract->supplier->company_name ?? 'N/A' }}</td>
                                                <td>{{ $contract->start_date }}</td>
                                                <td>{{ $contract->end_date }}</td>
                                                <td>{{ $contract->renewal_alert_sent ? 'Yes' : 'No' }}</td>
                                                <td>
                                                    <button wire:click="create({{ $contract->id }})"
                                                        class="btn btn-sm btn-info">Edit</button>
                                                    <button wire:click="delete({{ $contract->id }})"
                                                        class="btn btn-sm btn-danger">Delete</button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">No contracts found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2">
                        {{ $contracts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
