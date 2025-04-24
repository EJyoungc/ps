<div>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Tender Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Tenders</li>
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
                            <div class="d-flex justify-content-end gap-2 mb-3">
                                <div class="form-group">
                                    <input type="text" wire:model.live="search" placeholder="Search tenders..."
                                        class="form-control">
                                </div>
                                <div class="form-group">
                                    <button @click="$wire.create()" class="btn btn-primary">
                                        Add Tender <x-spinner for="create" />
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th>Deadline</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($tenders as $tender)
                                            <tr>
                                                <td>{{ $tender->title }}</td>
                                                <td>{{ Str::limit($tender->description, 50) }}</td>
                                                <td>{{ $tender->deadline->format('M d, Y') }}</td>
                                                <td>
                                                    <span
                                                        class="badge bg-{{ match ($tender->status) {
                                                            'open' => 'success',
                                                            'closed' => 'secondary',
                                                            'evaluating' => 'warning',
                                                            'awarded' => 'primary',
                                                            default => 'dark',
                                                        } }}">
                                                        {{ ucfirst($tender->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <button wire:click="create({{ $tender->id }})"
                                                        class="btn btn-sm btn-warning">
                                                        Edit
                                                    </button>
                                                    <button wire:click="delete({{ $tender->id }})"
                                                        class="btn btn-sm btn-danger">
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No tenders found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="p-3">
                                {{ $tenders->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <x-modal :title="$id ? 'Edit Tender' : 'Create New Tender'" :status="$modal">
        <form wire:submit.prevent="store">
            <div class="modal-body">
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" wire:model="title">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" wire:model="description" rows="4"></textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Deadline</label>
                    <input type="date" class="form-control @error('deadline') is-invalid @enderror"
                        wire:model="deadline" min="{{ now()->format('Y-m-d') }}">
                    @error('deadline')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select class="form-control @error('status') is-invalid @enderror" wire:model="status">
                        <option value="">Select Status</option>
                        <option value="open">Open</option>
                        <option value="closed">Closed</option>
                        <option value="evaluating">Evaluating</option>
                        <option value="awarded">Awarded</option>
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
