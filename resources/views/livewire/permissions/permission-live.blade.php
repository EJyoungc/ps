<div>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Permissions Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.users') }}">Users</a></li>
                        <li class="breadcrumb-item active">Permissions</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-end">

                        <div class="d-flex">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Search permissions..."
                                    wire:model.live="search">

                            </div>
                            <div class="form-group pl-1">
                                <button class="btn btn-primary " wire:click="create">
                                    <i class="fas fa-plus"></i> Add
                                    <x-spinner for="create" />
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card">

                        <div class="card-body">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($permissions as $permission)
                                        <tr>
                                            <td>{{ $permission->name }}</td>
                                            <td>
                                                <button wire:click="edit({{ $permission->id }})"
                                                    class="btn btn-sm btn-info">
                                                    <i class="fas fa-edit"></i> Edit 
                                                </button>
                                                <button wire:click="confirmDelete({{ $permission->id }})"
                                                    class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="text-center">No permissions found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Edit/Create Modal -->
    <x-modal title="{{ $selectedPermission ? 'Edit Permission' : 'Create New Permission' }}"
        status="{{ $modal }}">
        <form wire:submit.prevent="save">

            <div class="form-group">
                <label>Permission Name</label>
                <input type="text" class="form-control" wire:model="name" autofocus>
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>



            <button type="submit" class="btn btn-primary">
                {{ $selectedPermission ? 'Update' : 'Create' }}
            </button>

        </form>
    </x-modal>


    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" wire:ignore.self aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="btn-close" wire:click="closeModal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this permission?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal">Cancel</button>
                    <button type="button" class="btn btn-danger" wire:click="delete({{ $selectedPermission?->id }})">
                        Confirm Delete
                    </button>
                </div>
            </div>
        </div>
    </div>

    @script
        <script>
            document.addEventListener('livewire:initialized', () => {
                const permissionModal = new bootstrap.Modal('#permissionModal');
                const deleteModal = new bootstrap.Modal('#deleteModal');

                Livewire.on('modal-open', () => {
                    if (@this.modal) {
                        permissionModal.show();
                    }
                    if (@this.confirmModal) {
                        deleteModal.show();
                    }
                });

                Livewire.on('modal-cancel', () => {
                    permissionModal.hide();
                    deleteModal.hide();
                });
            });
        </script>
    @endscript
</div>
