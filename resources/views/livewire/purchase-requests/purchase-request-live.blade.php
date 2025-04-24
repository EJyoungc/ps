<div>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Purchase Requests</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Purchase Requests</li>
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
                                    <input type="text" class="form-control" placeholder="Search requests..."
                                        wire:model.live.debounce.300ms="search">
                                </div>
                                <button @click="$wire.create()" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus"></i> New Request
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Requester</th>
                                            <th>Department</th>
                                            <th>Items</th>
                                            <th>Estimated Cost</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($requests as $request)
                                            <tr>
                                                <td>{{ $request->user->name }}</td>
                                                <td>{{ $request->department->name }}</td>
                                                <td>{{ Str::limit($request->items, 30) }}</td>
                                                <td>{{ number_format($request->estimated_cost, 2) }}</td>
                                                <td>
                                                    <span
                                                        class="badge badge-{{ $request->status === 'approved'
                                                            ? 'success'
                                                            : ($request->status === 'rejected'
                                                                ? 'danger'
                                                                : ($request->status === 'completed'
                                                                    ? 'primary'
                                                                    : 'warning')) }}">
                                                        {{ ucfirst($request->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <button wire:click="create({{ $request->id }})"
                                                        class="btn btn-sm btn-warning">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button wire:click="delete({{ $request->id }})"
                                                        class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No requests found</td>
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

    <x-modal title="{{ $id ? 'Edit Request' : 'Create New Request' }}" :status="$modal">
        <form wire:submit.prevent="store">
            <div class="modal-body">
                <div class="form-group">
                    <label>Requester</label>
                    <select class="form-control @error('user_id') is-invalid @enderror" wire:model="user_id" required>
                        <option value="">Select User</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Department</label>
                    <select class="form-control @error('department_id') is-invalid @enderror" wire:model="department_id"
                        required>
                        <option value="">Select Department</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    </select>
                    @error('department_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Items</label>
                    <textarea class="form-control @error('items') is-invalid @enderror" wire:model="items" rows="3" required></textarea>
                    @error('items')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Specifications</label>
                    <textarea class="form-control @error('specifications') is-invalid @enderror" wire:model="specifications" rows="3"
                        required></textarea>
                    @error('specifications')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Estimated Cost</label>
                    <input type="number" step="0.01"
                        class="form-control @error('estimated_cost') is-invalid @enderror" wire:model="estimated_cost"
                        required>
                    @error('estimated_cost')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select class="form-control @error('status') is-invalid @enderror" wire:model="status" required>
                        <option value="">Select Status</option>
                        <option value="draft">Draft</option>
                        <option value="submitted">Submitted</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                        <option value="completed">Completed</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
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
