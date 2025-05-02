<div>


    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Tender: {{   !empty($tender->id) ? $tender->title : 'unknown'  }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">{{ !empty($tender->id) ? $tender->title : 'unknown' }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid" >

            <!-- Default box -->
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-end">
                    <div class="form-group">
                        <input type="text" placeholder="search" class="form-control">
                    </div>
                    <div class="form-group">
                        <button @click="$wire.create(); $wire.dispatch('modal-open');"
                            class="btn-primary btn-sm"> Add <x-spinner for="create" /></button>
                    </div>

                    <x-modal title="modal" :status="$modal">
                        <form wire:submit='store'>

                            <div class="form-group">
                                <button type="submit" class="btn btn-dark">save<x-spinner for="store" /></button>
                            </div>
                        </form>
                    </x-modal>
                </div>
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
                                    @forelse($bids as $index => $bid)
                                        <tr>
                                            <td>{{ $bid->id }}

                                            </td>
                                            <td>{{ $bid->tender->title }}</td>
                                            <td>{{ $bid->supplier->company_name }} <br>
                                                {{ $bid->supplier->user->email }}

                                            </td>
                                            <td>{{ number_format($bid->amount, 2) }} <br>   @if ($index == 0)
                                                <span class="badge badge-success">Recommended</span>
                                            @endif</td>
                                            <td>{{ ucfirst(str_replace('_', ' ', $bid->status)) }}</td>
                                            <td>
                                              <div class="dropdown open">
                                                <a class="btn btn-secondary dropdown-toggle" type="button" id="triggerId" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                            option
                                              </a>
                                                <div class="dropdown-menu" aria-labelledby="triggerId">
                                                    <a class="dropdown-item" wire:click.prevent="status_update({{ $bid->id }},'accepted')" href="#">Accept</a>
                                                    <a class="dropdown-item" wire:click.prevent="status_update({{ $bid->id }},'rejected')" href="#">reject</a>
                                                    <a class="dropdown-item" wire:click.prevent="status_update({{ $bid->id }},'under_review')" href="#">under review</a>
                                                </div>
                                              </div>
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
            </div>
        </div>


        </div>



    </section>





</div>
