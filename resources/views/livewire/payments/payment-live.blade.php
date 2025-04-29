<div>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Payments</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Payments</li>
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
                        <input type="text" wire:model="search" placeholder="Search payments..." class="form-control">
                    </div>
                    <div class="form-group">
                        <button @click="$wire.create(); $wire.dispatch('modal-open');" class="btn btn-primary btn-sm">
                            Add <x-spinner for="create" />
                        </button>
                    </div>

                    <x-modal title="Payment" :status="$modal">
                        <form wire:submit.prevent='store'>
                            <div class="form-group">
                                <label>Invoice ID</label>
                                <input type="text" wire:model.defer="invoice_id" class="form-control">
                                @error('invoice_id') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group">
                                <label>Amount</label>
                                <input type="number" step="0.01" wire:model.defer="amount" class="form-control">
                                @error('amount') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group">
                                <label>Payment Date</label>
                                <input type="date" wire:model.defer="payment_date" class="form-control">
                                @error('payment_date') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group">
                                <label>Reference Number</label>
                                <input type="text" wire:model.defer="reference_number" class="form-control">
                                @error('reference_number') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group mt-3">
                                <button type="submit" class="btn btn-dark">Save <x-spinner for="store" /></button>
                                <button type="button" wire:click="cancel" class="btn btn-secondary">Cancel</button>
                            </div>
                        </form>
                    </x-modal>
                </div>

                <div class="card">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead class="thead-inverse">
                                    <tr>
                                        <th>ID</th>
                                        <th>Invoice ID</th>
                                        <th>Amount</th>
                                        <th>Payment Date</th>
                                        <th>Reference Number</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($payments as $payment)
                                        <tr>
                                            <td>{{ $payment->id }}</td>
                                            <td>{{ $payment->invoice_id }}</td>
                                            <td>{{ $payment->amount }}</td>
                                            <td>{{ $payment->payment_date }}</td>
                                            <td>{{ $payment->reference_number }}</td>
                                            <td>
                                                <button wire:click="create({{ $payment->id }})" class="btn btn-sm btn-warning">Edit</button>
                                                <button wire:click="delete({{ $payment->id }})" class="btn btn-sm btn-danger">Delete</button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No Payments Found</td>
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
