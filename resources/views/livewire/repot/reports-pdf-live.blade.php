<div class="p-4">
    <div class="form-group">
        <label for="reportType">Select Report:</label>
        <select id="reportType" wire:model.live="reportType" class="form-control w-50">
            @foreach($reports as $key => $label)
                <option value="{{ $key }}">{{ $label }}</option>
            @endforeach
        </select>
    </div>

    <button wire:click="generatePdf" class="btn btn-primary mb-4">Download PDF</button>

    <div class="card">
        <div class="card-header">
            <h3>{{ $title }}</h3>
        </div>
        <div class="card-body">
            @switch($reportType)
                @case('overview')
                    <table class="table table-bordered">
                        <thead><tr><th>Entity</th><th>Count</th></tr></thead>
                        <tbody>
                            @foreach($reportData as $entity => $count)
                                <tr><td>{{ ucwords(str_replace('_',' ',$entity)) }}</td><td>{{ $count }}</td></tr>
                            @endforeach
                        </tbody>
                    </table>
                    @break

                @case('purchase_requests')
                    <p><strong>Total Cost:</strong> {{ number_format($reportData['total_cost'],2) }} &nbsp;
                       <strong>Approved:</strong> {{ $reportData['approved'] }} &nbsp;
                       <strong>Rejected:</strong> {{ $reportData['rejected'] }}</p>
                    <table class="table table-striped">
                        <thead><tr><th>ID</th><th>Requester</th><th>Dept</th><th>Cost</th><th>Status</th><th>Date</th></tr></thead>
                        <tbody>
                            @foreach($reportData['records'] as $pr)
                                <tr>
                                    <td>{{ $pr->id }}</td>
                                    <td>{{ $pr->user->name }}</td>
                                    <td>{{ $pr->department->name }}</td>
                                    <td>{{ number_format($pr->estimated_cost,2) }}</td>
                                    <td>{{ ucfirst($pr->status) }}</td>
                                    <td>{{ $pr->created_at->format('Y-m-d') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @break

                @case('tenders')
                    <p><strong>Total Bids Amount:</strong> {{ number_format($reportData['total_bids_amount'],2) }} &nbsp;
                       <strong>Accepted:</strong> {{ $reportData['accepted_bids'] }} &nbsp;
                       <strong>Rejected:</strong> {{ $reportData['rejected_bids'] }}</p>
                    <table class="table table-striped">
                        <thead><tr><th>ID</th><th>Title</th><th>Deadline</th><th>Bids</th><th>Status</th></tr></thead>
                        <tbody>
                            @foreach($reportData['records'] as $t)
                                <tr>
                                    <td>{{ $t->id }}</td>
                                    <td>{{ $t->title }}</td>
                                    <td>{{ $t->deadline->format('Y-m-d') }}</td>
                                    <td>{{ $t->bids_count }}</td>
                                    <td>{{ ucfirst($t->status) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @break

                @case('inventory')
                    <table class="table table-striped">
                        <thead><tr><th>ID</th><th>Name</th><th>Stock</th><th>Min</th><th>Unit</th></tr></thead>
                        <tbody>
                            @foreach($reportData['records'] as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->current_stock }}</td>
                                    <td>{{ $item->minimum_stock }}</td>
                                    <td>{{ $item->unit_of_measure }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @break

                @case('financial')
                    <p><strong>Total Invoice:</strong> {{ number_format($reportData['total_invoices'],2) }} &nbsp;
                       <strong>Total Payments:</strong> {{ number_format($reportData['total_payments'],2) }} &nbsp;
                       <strong>Paid:</strong> {{ $reportData['invoices_paid'] }} &nbsp;
                       <strong>Pending:</strong> {{ $reportData['invoices_pending'] }}</p>
                    <h5>Invoices</h5>
                    <table class="table table-striped mb-4">
                        <thead><tr><th>No</th><th>Amt</th><th>Status</th><th>Due</th></tr></thead>
                        <tbody>
                            @foreach($reportData['invoices'] as $inv)
                                <tr>
                                    <td>{{ $inv->invoice_number }}</td>
                                    <td>{{ number_format($inv->amount,2) }}</td>
                                    <td>{{ ucfirst($inv->status) }}</td>
                                    <td>{{ $inv->due_date->format('Y-m-d') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <h5>Payments</h5>
                    <table class="table table-striped">
                        <thead><tr><th>ID</th><th>Inv#</th><th>Amt</th><th>Date</th></tr></thead>
                        <tbody>
                            @foreach($reportData['payments'] as $pay)
                                <tr>
                                    <td>{{ $pay->id }}</td>
                                    <td>{{ $pay->invoice->invoice_number }}</td>
                                    <td>{{ number_format($pay->amount,2) }}</td>
                                    <td>{{ $pay->payment_date->format('Y-m-d') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @break

            @endswitch
        </div>
    </div>
</div>
