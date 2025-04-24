<div>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Supplier Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Suppliers</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="w-25">
                                    <input type="text"
                                           class="form-control"
                                           placeholder="Search suppliers..."
                                           wire:model.live.debounce.300ms="search">
                                </div>
                                <button @click="$wire.create()"
                                        class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus"></i> Add Supplier
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Company</th>
                                            <th>Contact Person</th>
                                            <th>Phone</th>
                                            <th>Status</th>
                                            <th>User</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($suppliers as $supplier)
                                            <tr>
                                                <td>{{ $supplier->company_name }}</td>
                                                <td>{{ $supplier->contact_person }}</td>
                                                <td>{{ $supplier->phone }}</td>
                                                <td>
                                                    <span class="badge badge-{{
                                                        $supplier->status === 'approved' ? 'success' :
                                                        ($supplier->status === 'rejected' ? 'danger' : 'warning')
                                                    }}">
                                                        {{ ucfirst($supplier->status) }}
                                                    </span>
                                                </td>
                                                <td>{{ $supplier->user->name }}</td>
                                                <td>
                                                    <button wire:click="create({{ $supplier->id }})"
                                                            class="btn btn-sm btn-warning">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button wire:click="confirmDelete({{ $supplier->id }})"
                                                            class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No suppliers found</td>
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

    <x-modal title="{{ $id ? 'Edit Supplier' : 'Create New Supplier' }}" :status="$modal">
        <form wire:submit.prevent="{{ $id ? 'update' : 'store' }}">
            <div class="modal-body">
                <div class="form-group">
                    <label>Associated User</label>
                    <select class="form-control @error('user_id') is-invalid @enderror"
                            wire:model="user_id" required>
                        <option value="">Select User</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('user_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label>Company Name</label>
                    <input type="text"
                           class="form-control @error('company_name') is-invalid @enderror"
                           wire:model="company_name" required>
                    @error('company_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label>Contact Person</label>
                    <input type="text"
                           class="form-control @error('contact_person') is-invalid @enderror"
                           wire:model="contact_person" required>
                    @error('contact_person') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="tel"
                           class="form-control @error('phone') is-invalid @enderror"
                           wire:model="phone" required>
                    @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label>Address</label>
                    <textarea class="form-control @error('address') is-invalid @enderror"
                              wire:model="address" rows="3" required></textarea>
                    @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select class="form-control @error('status') is-invalid @enderror"
                            wire:model="status" required>
                        <option value="">Select Status</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                    </select>
                    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" wire:click="cancel">Cancel</button>
                <button type="submit" class="btn btn-primary">
                    {{ $id ? 'Update' : 'Create' }}
                </button>
            </div>
        </form>
    </x-modal>
</div>
