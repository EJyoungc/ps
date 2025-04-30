<div>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Available Tenders</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">My Bids</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-lg-6">
                    <div class="card bg-primary">
                        <div class="card-body">
                            <h3>Tenders</h3>
                            <h6>{{ $tenders->count() }}</h6>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="card bg-success">
                        <div class="card-body">
                            <h3>Tenders</h3>
                            <h6>{{ $myBids->count() }}</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Tenders</h3>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Deadline</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tenders as $tender)
                                        <tr>
                                            <td>{{ $tender->id }}</td>
                                            <td>{{ $tender->title }}</td>
                                            <td>{{ $tender->deadline->format('Y-m-d') }}</td>
                                            <td>{{ ucfirst($tender->status) }}</td>
                                            <td>
                                                @if ($tender->status == 'open')
                                                <button wire:click="create({{ $tender->id }})" class="btn btn-sm btn-primary">
                                                    Place Bid
                                               </button>

                                                @else

                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer clearfix">
                            {{ $tenders->links() }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">My Bids</h3>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Tender</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Submitted On</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($myBids as $bid)
                                        <tr>
                                            <td>{{ $bid->tender->title }}</td>
                                            <td>{{ number_format($bid->amount,2) }}</td>
                                            <td>{{ ucfirst(str_replace('_',' ', $bid->status)) }}</td>
                                            <td>{{ $bid->created_at->format('Y-m-d') }}</td>
                                            <td>
                                                <button wire:click="create({{ $bid->id }})" class="btn btn-sm btn-primary">
                                                     Edit Bid
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="text-center">You have not placed any bids yet.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <x-modal title="Submit Bid" :status="$modal">
            <form wire:submit.prevent="store">
                <div class="form-group">
                    <label>Amount</label>
                    <input type="number" wire:model="amount" class="form-control" step="0.01" />
                    @error('amount')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label>Proposal</label>
                    <textarea wire:model="proposal" class="form-control" rows="4"></textarea>
                    @error('proposal')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select wire:model="status"  class="form-control readonly"> ">
                        <option selected value="submitted">Submitted</option>
                    </select>
                    @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
                <div class="d-flex justify-content-end">
                    <button type="button" wire:click="cancel" class="btn btn-secondary mr-2">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </x-modal>
    </section>
</div>
