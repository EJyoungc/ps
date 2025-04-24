<div>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>User Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Users</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-end ">
                        <div class="form-group">
                            <button @click="$wire.create(); $wire.dispatch('modal-open');"
                                class="btn btn-primary btn-sm">
                                Add User <x-spinner for="create" />
                            </button>
                        </div>
                        <div class="form-group pl-1">
                            <a href="{{ route('permissions') }}" class="btn btn-info btn-sm">
                                <i class="fas fa-shield-alt"></i> Manage Permissions
                            </a>
                        </div>
                    </div>
                    <div class="card">

                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Roles</th>
                                            <th>Permissions</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td><span class="badge badge-info text-capitalize">{{ $user->getRoleNames()->join(', ') }} </span></td>
                                                <td>{{ $user->getPermissionNames()->join(', ') }}</td>
                                                <td>
                                                    <button wire:click="update_roles_permissions('{{ $user->id }}')"
                                                        class="btn btn-sm btn-primary">
                                                        Edit Roles and Permissions
                                                        <x-spinner for="update_roles_permissions" />
                                                    </button>
                                                    <button wire:click="confirmDelete({{ $user->id }})"
                                                        class="btn btn-sm btn-danger">
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <x-modal title="{{ $selectedUser ? 'Edit User: ' . $selectedUser->name : 'Add User' }}" :status="$modal_roles">
        <form wire:submit.prevent="update">
            <div class="row">
                <div class="col-md-6">
                    <h5>Roles</h5>
                    @foreach ($roles as $role)
                        <div class="form-check">
                            <input wire:model="selectedRoles" class="form-check-input" type="checkbox"
                                value="{{ $role->name }}" id="role_{{ $role->id }}">
                            <label class="form-check-label" for="role_{{ $role->id }}">
                                {{ $role->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
                <div class="col-md-6">
                    <h5>Permissions</h5>
                    @foreach ($permissions as $permission)
                        <div class="form-check">
                            <input wire:model="selectedPermissions" class="form-check-input" type="checkbox"
                                value="{{ $permission->name }}" id="perm_{{ $permission->id }}">
                            <label class="form-check-label" for="perm_{{ $permission->id }}">
                                {{ $permission->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="form-group mt-3">
                <button type="submit" class="btn btn-dark">
                    Save Changes <x-spinner for="update" />
                </button>
                <button type="button" class="btn btn-default" wire:click="cancel">Cancel</button>
            </div>
        </form>
    </x-modal>

    <x-modal title="Create User" :status="$modal">
        <form wire:submit.prevent="store">
            <div class="form-group">
                <label for="">Name</label>
                <input type="text" class="form-control" wire:model='name'>
                <x-error for="name" />
            </div>
            <div class="form-group">
                <label for="">Email</label>
                <input type="email" class="form-control" wire:model='email'>
                <x-error for="email" />
            </div>
            <div class="form-group">
                <label for="">Password</label>
                <input type="password" class="form-control" wire:model='password'>
                <x-error for="password" />
            </div>

            <div class="form-group mt-3">
                <button type="submit" class="btn btn-primary">
                    Save <x-spinner for="store" />
                </button>
            </div>

        </form>
    </x-modal>
</div>
