<div class="vh-100 d-flex justify-content-center align-items-center bg-light">
    <x-modal status="{{ $modal }}" title="Add Organization">
        <form wire:submit.prevent="store">
            <div class="modal-body">
                <div class="form-group">
                    <label>Company Name</label>
                    <input type="text" class="form-control @error('company_name') is-invalid @enderror"
                        wire:model.defer="company_name" required>
                    @error('company_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Contact Person</label>
                    <input type="text" class="form-control @error('contact_person') is-invalid @enderror"
                        wire:model.defer="contact_person" required>
                    @error('contact_person')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                        wire:model.defer="phone" required>
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Address</label>
                    <textarea class="form-control @error('address') is-invalid @enderror" wire:model.defer="address" rows="3"
                        required></textarea>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-dark">Save <x-spinner for="store" /></button>
            </div>
        </form>
    </x-modal>

    <div class="card col-11 col-lg-5">
        @if (empty($organization))
            <div class="card-body">
                <h3 class="text-bold">Organization</h3>
                <div class="d-flex mb-2">
                    <input type="text" class="form-control rounded-pill mr-2" wire:model.live="search"
                        placeholder="Search for Organization">
                    <button wire:click.prevent="create" class="btn btn-dark rounded-circle mr-1">
                        <i class="fa fa-plus" wire:loading.remove wire:target="create"></i>
                        <x-spinner for="create" />
                    </button>
                    <button wire:click.prevent="get_all_orgs" class="btn btn-dark rounded-circle">
                        <i class="fa fa-list" wire:loading.remove wire:target="get_all_orgs"></i>
                        <x-spinner for="get_all_orgs" />
                    </button>
                </div>
                <small class="text-muted">Select the organization; if not found, add a new one</small>

                @if (!empty($search))
                    <ul class="list-group mt-2">
                        @forelse ($organizations as $item)
                            <li class="list-group-item d-flex align-items-center"
                                wire:click.prevent="select_org({{ $item->id }})">
                                <i class="fas fa-angle-right"></i>
                                <span class="pl-2 text-capitalize">{{ $item->company_name }}</span>
                            </li>
                        @empty
                            <li class="list-group-item text-center">No organizations found.</li>
                        @endforelse
                    </ul>
                @endif

                <button class="btn btn-primary w-100 mt-2" wire:click.prevent="save"
                    @if (empty($organization)) disabled @endif>
                    Save <x-spinner for="save" />
                </button>

                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button type="submit" class="btn btn-danger w-100">Logout</button>
                </form>
            </div>
        @else
            <div class="card-body">
                <div class="alert alert-info">
                    <strong>Info:</strong>
                    <p>Dear <strong>{{ Auth::user()->name }}</strong>,<br>
                        You have an organization <strong>{{ $organization->company_name }}</strong>.<br>
                        <a href="{{ route('dashboard') }}" class="btn btn-link p-0">Dahsboard</a>
                    </p>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger w-100">Logout</button>
                </form>
            </div>
        @endif
    </div>
</div>
