<div>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Notifications</h1>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Status</th>
                                    <th>Type</th>
                                    <th>Message</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($notifications as $note)
                                    <tr class="{{ $note->read ? '' : 'font-weight-bold' }}" 
                                        wire:click.prevent="open({{ $note->id }})" style="cursor:pointer;">
                                        <td>
                                            @if($note->read)
                                                <span class="badge badge-secondary">Read</span>
                                            @else
                                                <span class="badge badge-primary">New</span>
                                            @endif
                                        </td>
                                        <td>{{ ucfirst($note->type) }}</td>
                                        <td>{{ Str::limit($note->message, 50) }}</td>
                                        <td>{{ $note->created_at->diffForHumans() }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <x-modal title="Notification Details" :status="$modal">
                @if($selected)
                    <div class="modal-body">
                        <p><strong>Type:</strong> {{ ucfirst($selected->type) }}</p>
                        <p><strong>Message:</strong></p>
                        <p>{{ $selected->message }}</p>
                        <p><small>{{ $selected->created_at->format('Y-m-d H:i') }}</small></p>
                    </div>
                    <div class="modal-footer">
                        <button wire:click="close" class="btn btn-secondary">Close</button>
                    </div>
                @endif
            </x-modal>
        </div>
    </section>
</div>