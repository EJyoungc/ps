<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Supplier;
use App\Models\Department;
use App\Models\PurchaseRequest;
use App\Models\Tender;
use App\Models\Bid;
use App\Models\PurchaseOrder;
use App\Models\Contract;
use App\Models\Shipment;
use App\Models\InventoryItem;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;

class DashboardLive extends Component
{
    public $stats = [];
    public $aggregates = [];
    public $userRoles = [];

    #[Computed]    
    public function getRandomColor()
    {
        $colors = [
            'primary',
            'secondary',
            'success',
            'danger',
            'warning',
            'info',
            'light',
            'dark'
        ];

        return 'bg-' . $colors[array_rand($colors)];
    }

    public function mount()
    {
        $user = Auth::user();

        // Counts
        $this->stats = [
            'Users' => User::count(),
            'Suppliers' => Supplier::count(),
            'Departments' => Department::count(),
            'Purchase Requests' => PurchaseRequest::count(),
            'Tenders' => Tender::count(),
            'Bids' => Bid::count(),
            'Purchase Orders' => PurchaseOrder::count(),
            'Contracts' => Contract::count(),
            'Shipments' => Shipment::count(),
            'Inventory Items' => InventoryItem::count(),
            'Invoices' => Invoice::count(),
            'Payments' => Payment::count(),
        ];

        // Financial & status aggregates
        $prs = PurchaseRequest::all();
        $this->aggregates['PR Total Cost'] = $prs->sum('estimated_cost');
        $this->aggregates['PR Approved'] = $prs->where('status','approved')->count();
        $this->aggregates['PR Rejected'] = $prs->where('status','rejected')->count();

        $bids = Bid::all();
        $this->aggregates['Bid Total Amount'] = $bids->sum('amount');
        $this->aggregates['Bids Accepted'] = $bids->where('status','accepted')->count();
        $this->aggregates['Bids Rejected'] = $bids->where('status','rejected')->count();

        $invs = Invoice::all();
        $this->aggregates['Invoice Total Amt'] = $invs->sum('amount');
        $this->aggregates['Invoices Paid'] = $invs->where('status','paid')->count();
        $this->aggregates['Invoices Pending'] = $invs->where('status','pending')->count();

        // Roles via Spatie
        $this->userRoles = $user->getRoleNames()->toArray();
    }

    public function render()
    {
        return view('livewire.dashboard-live', [
            'stats' => $this->stats,
            'aggregates' => $this->aggregates,
            'bids'=>Bid::where('supplier_id',Auth::id())->count(),
            'po'=>PurchaseOrder::where('supplier_id',Auth::id())->count(),
            'userRoles' => $this->userRoles,
        ]);
    }
}
