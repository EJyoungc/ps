<?php

namespace App\Livewire\Repot;

use App\Models\Bid;
use App\Models\PurchaseOrder;
use App\Models\Contract;
use App\Models\Shipment;
use App\Models\InventoryItem;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\PurchaseRequest;
use App\Models\Tender;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Component; use App\Services\NS;

class ReportsPdfLive extends Component
{
    public $reportType = 'overview';
    public $reportData;
    public $title;

    public $reports = [
        'overview' => 'Overall System Report',
        'purchase_requests' => 'Purchase Requests Report',
        'tenders' => 'Tenders Report',
        'inventory' => 'Inventory Stock Report',
        'financial' => 'Financial Transactions Report',
    ];

    public function mount()
    {
        $this->loadData();
    }

    public function updatedReportType()
    {
        $this->loadData();
    }

    protected function loadData()
    {
        $this->title = $this->reports[$this->reportType] ?? 'Report';

        switch ($this->reportType) {
            case 'purchase_requests':
                $all = PurchaseRequest::with(['user', 'department'])->get();
                $this->reportData = [
                    'records' => $all,
                    'total_cost' => $all->sum('estimated_cost'),
                    'approved' => $all->where('status', 'approved')->count(),
                    'rejected' => $all->where('status', 'rejected')->count(),
                ];
                break;

            case 'tenders':
                $records = Tender::withCount('bids')->get();
                $this->reportData = [
                    'records' => $records,
                    'total_bids_amount' => Bid::sum('amount'),
                    'accepted_bids' => Bid::where('status', 'accepted')->count(),
                    'rejected_bids' => Bid::where('status', 'rejected')->count(),
                ];
                break;

            case 'inventory':
                $this->reportData = ['records' => InventoryItem::all()];
                break;

            case 'financial':
                $invoices = Invoice::with('purchaseOrder')->get();
                $payments = Payment::with('invoice')->get();
                $this->reportData = [
                    'invoices' => $invoices,
                    'payments' => $payments,
                    'total_invoices' => $invoices->sum('amount'),
                    'total_payments' => $payments->sum('amount'),
                    'invoices_paid' => $invoices->where('status', 'paid')->count(),
                    'invoices_pending' => $invoices->where('status', 'pending')->count(),
                ];
                break;

            default:
                $this->reportData = [
                    'purchase_requests' => PurchaseRequest::count(),
                    'tenders' => Tender::count(),
                    'bids' => Bid::count(),
                    'purchase_orders' => PurchaseOrder::count(),
                    'contracts' => Contract::count(),
                    'shipments' => Shipment::count(),
                    'inventory_items' => InventoryItem::count(),
                    'invoices' => Invoice::count(),
                    'payments' => Payment::count(),
                ];
        }
    }

    public function generatePdf()
    {
        $pdf = Pdf::loadView('reports.pdf.universal', [
            'data' => $this->reportData,
            'title' => $this->title,
            'reportType' => $this->reportType,
        ]);

        return response()->streamDownload(
            fn() => print($pdf->output()),
            str()->slug($this->title) . '.pdf'
        );
    }

    public function render()
    {
        return view('livewire.repot.reports-pdf-live');
    }
}
