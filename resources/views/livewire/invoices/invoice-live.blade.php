<div>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Invoices</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Invoices</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="row mb-2">
                <div class="col-12 d-flex justify-content-end">
                    <input type="text" wire:model="search" placeholder="Search Invoices" class="form-control w-25 mr-2">
                    <button @click="$wire.create(); $wire.dispatch('modal-open');" class="btn btn-primary btn-sm">
                        Add Invoice <x-spinner for="create" />
                    </button>

                    <x-modal title="Invoice" :status="$modal">
                        <form wire:submit.prevent="store">
                            <div class="form-group">
                                <label>Purchase Order</label>
                                <select wire:model="purchase_order_id" class="form-control">
                                    <option value="">Select PO</option>
                                    @foreach($purchaseOrders as $po)
                                        <option value="{{ $po->id }}">{{ $po->id }} - {{ $po->description ?? '' }}</option>
                                    @endforeach
                                </select>
                                @error('purchase_order_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label>Invoice Number</label>
                                <input type="text" wire:model="invoice_number" class="form-control">
                                @error('invoice_number') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label>Amount</label>
                                <input type="number" wire:model="amount" class="form-control" step="0.01">
                                @error('amount') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label>Due Date</label>
                                <input type="date" wire:model="due_date" class="form-control">
                                @error('due_date') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label>Status</label>
                                <select wire:model="status" class="form-control">
                                    <option value="">Select Status</option>
                                    <option value="pending">Pending</option>
                                    <option value="verified">Verified</option>
                                    <option value="paid">Paid</option>
                                    <option value="disputed">Disputed</option>
                                </select>
                                @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group mt-2">
                                <button type="submit" class="btn btn-dark">Save <x-spinner for="store" /></button>
                            </div>
                        </form>
                    </x-modal>
                </div>
            </div>

            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Invoice No.</th>
                                    <th>PO ID</th>
                                    <th>Amount</th>
                                    <th>Due Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($invoices as $invoice)
                                    <tr>
                                        <td>{{ $invoice->invoice_number }}</td>
                                        <td>{{ $invoice->purchase_order_id }}</td>
                                        <td>${{ number_format($invoice->amount, 2) }}</td>
                                        <td>{{ $invoice->due_date }}</td>
                                        <td>
                                            <span class="badge
                                                {{
                                                    $invoice->status == 'pending' ? 'badge-warning' :
                                                    ($invoice->status == 'verified' ? 'badge-info' :
                                                    ($invoice->status == 'paid' ? 'badge-success' : 'badge-danger'))
                                                }}">
                                                {{ ucfirst($invoice->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <button wire:click="create({{ $invoice->id }})" class="btn btn-sm btn-info">Edit</button>
                                            <button wire:click="delete({{ $invoice->id }})" class="btn btn-sm btn-danger">Delete</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="text-center">No Invoices Found</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer">
                    {{ $invoices->links() }}
                </div>
            </div>

        </div>
    </section>
</div>
