<div>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Dashboard</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <h3>Key Metrics</h3>
            <div class="row">
                @role('admin')
                    @foreach ($stats as $label => $count)
                        <div class="col-6 col-md-4 col-lg-3 mb-3">
                            <div class="card {{ $this->getRandomColor() }}">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <h5>{{ $label }}</h5>
                                        <h3>{{ $count }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    {{-- Non-admins see limited metrics based on role --}}
                    @if (in_array('procurement_officer', $userRoles))
                        <div class="col-md-6">
                            <x-stats-card title="Purchase Requests" :count="$stats['Purchase Requests']" />
                        </div>
                        <div class="col-md-6">
                            <x-stats-card title="Tenders" :count="$stats['Tenders']" />
                        </div>
                    @elseif(in_array('supplier', $userRoles))
                        <div class="col-md-6">
                            <x-stats-card title="My Bids" :count="$bids" />
                        </div>
                        <div class="col-md-6">
                            <x-stats-card title="My POs" :count="$po" />
                        </div>
                    @elseif(in_array('finance_officer', $userRoles))
                        <div class="col-md-6">
                            <x-stats-card title="Invoices Total" :count="$aggregates['Invoice Total Amt']" />
                        </div>
                        <div class="col-md-6">
                            <x-stats-card title="Payments Total" :count="$aggregates['Bid Total Amount']" />
                        </div>
                    @endif
                @endrole
            </div>

            <h3>Summary</h3>
            <div class="row">
                @foreach ($aggregates as $label => $value)
                    <div class="col-6 col-md-4 col-lg-3 mb-3">
                        <div class="card border-secondary">
                            <div class="card-body">
                                <h6 class="card-subtitle mb-2 text-muted">{{ $label }}</h6>
                                <p class="card-text">{{ is_numeric($value) ? number_format($value, 2) : $value }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <h3>More Details</h3>
            <div class="row">
                {{-- Example: Supplier sees only their stats --}}
                @if (in_array('supplier', $userRoles))
                    <div class="col-md-6">
                        <x-stats-card title=" Bids" :count="$bids" />
                    </div>
                    <div class="col-md-6">
                        <x-stats-card title=" POs" :count="$po" />
                    </div>
                @elseif(in_array('procurement_officer', $userRoles))
                    <div class="col-md-6">
                        <x-stats-card title="Purchase Requests" :count="$stats['Purchase Requests']" />
                    </div>
                    <div class="col-md-6">
                        <x-stats-card title="Tenders" :count="$stats['Tenders']" />
                    </div>
                @elseif(in_array('finance_officer', $userRoles))
                    <div class="col-md-6">
                        <x-stats-card title="Invoices Total" :count="$aggregates['Invoice Total Amt']" />
                    </div>
                    <div class="col-md-6">
                        <x-stats-card title="Payments Total" :count="$aggregates['Bids Total Amount']" />
                    </div>
                @endif
            </div>
        </div>
    </section>
</div>
