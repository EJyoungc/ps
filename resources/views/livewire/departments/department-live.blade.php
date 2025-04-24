<div>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Department Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Departments</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-end align-items-center">
                        <div class="d-flex">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Search departments..."
                                    wire:model.live.debounce.300ms="search">
                            </div>
                            <div class="form-group pl-1">
                                <button @click="$wire.create()" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Add Department
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card">

                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($departments as $department)
                                            <tr>
                                                <td>{{ $department->name }}</td>
                                                <td>{{ Str::limit($department->description, 50) }}</td>
                                                <td>{{ $department->created_at->format('d M Y') }}</td>
                                                <td>
                                                    <button wire:click="create({{ $department->id }})"
                                                        class="btn btn-sm btn-warning">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button wire:click="confirmDelete({{ $department->id }})"
                                                        class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">No departments found</td>
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

    <x-modal title="{{ $id ? 'Edit Department' : 'Create New Department' }}" :status="$modal">
        <form wire:submit.prevent="{{ $id ? 'update' : 'store' }}">
            <div class="modal-body">
                <div class="form-group">
                    <label>Department Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" wire:model="name"
                        autofocus>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" wire:model="description" rows="3"></textarea>
                    @error('description')
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
