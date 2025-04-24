<div>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Bids</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Bids</li>
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
                        <div class="form-group w-25">
                            <input type="text" wire:model.debounce.300ms="search" placeholder="Search bids..." class="form-control">
                        </div>
                        <div>
                            <button wire:click="create" class="btn btn-primary btn-sm">Add Bid <x-spinner for="create" /></button>
                        </div>
                    </div>

                    <x-modal title="{{ $bidId ? 'Edit Bid' : 'Create Bid' }}" :status="$modal">
                        <form wire:submit.prevent="{{ $bidId ? 'update' : 'store' }}">
                            <div class="form-group">
                                <label for="tender_id">Tender</label>
                                <select wire:model="tender_id" id="tender_id" class="form-control">
                                    <option value="">-- Select Tender --</option>
                                    @foreach($tenders as $id => $name)
                                        <option value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                                @error('tender_id') <span class="text-danger">{{ $message }}</span> @enderror
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
                                <label for="amount">Amount</label>
                                <input wire:model="amount" type="number" step="0.01" id="amount" class="form-control" />
                                @error('amount') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label for="proposal">Proposal</label>
                                <textarea wire:model="proposal" id="proposal" class="form-control" rows="4"></textarea>
                                @error('proposal') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label for="status">Status</label>
                                <select wire:model="status" id="status" class="form-control">
                                    <option value="submitted">Submitted</option>
                                    <option value="under_review">Under Review</option>
                                    <option value="accepted">Accepted</option>
                                    <option value="rejected">Rejected</option>
                                </select>
                                @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="button" wire:click="cancel" class="btn btn-secondary mr-2">Cancel</button>
                                <button type="submit" class="btn btn-dark">{{ $bidId ? 'Update' : 'Save' }} <x-spinner for="{{ $bidId ? 'update' : 'store' }}" /></button>
                            </div>
                        </form>
                    </x-modal>

                    <div class="card">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tender</th>
                                            <th>Supplier</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($bids as $bid)
                                            <tr>
                                                <td>{{ $bid->id }}</td>
                                                <td>{{ $bid->tender->title }}</td>
                                                <td>{{ $bid->supplier->company_name }}</td>
                                                <td>{{ number_format($bid->amount, 2) }}</td>
                                                <td>{{ ucfirst(str_replace('_', ' ', $bid->status)) }}</td>
                                                <td>
                                                    <button wire:click="create({{ $bid->id }})" class="btn btn-sm btn-info">Edit</button>
                                                    <button wire:click="delete({{ $bid->id }})" class="btn btn-sm btn-danger">Delete</button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No bids found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        {{ $bids->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
