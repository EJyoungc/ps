<?php

use App\Livewire\Bids\BidLive;
use App\Livewire\Bids\MyBidsLive;
use App\Livewire\Contracts\ContractLive;
use App\Livewire\DashboardLive;
use App\Livewire\Departments\DepartmentLive;
use App\Livewire\InventoryItems\InventoryItemLive;
use App\Livewire\Invoices\InvoiceLive;
use App\Livewire\Notifications\NotificationLive;
use App\Livewire\Payments\PaymentLive;
use App\Livewire\Permissions\PermissionLive;
use App\Livewire\Profile\ProfileLive;
use App\Livewire\PurchaseOrders\PurchaseOrderLive;
use App\Livewire\PurchaseRequests\PurchaseRequestLive;
use App\Livewire\Repot\ReportsPdfLive;
use App\Livewire\Repots\ReportLive;
use App\Livewire\Shipments\ShipmentLive;
use App\Livewire\Suppliers\SupplierLive;
use App\Livewire\Supplies\SupplierCheckLive;
use App\Livewire\Tenders\TenderBidsLive;
use App\Livewire\Tenders\TenderLive;
use App\Livewire\Users\UserLive;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get("/", function () { return view("welcome"); })->name('dashboard');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/use/profile',ProfileLive::class)->name('profile');

    Route::get('/dashboard',DashboardLive::class)->name('dashboard');
     // Admin Routes
     Route::middleware(['role:admin'])->prefix('admin')->group(function () {

Route::get('/permissions',PermissionLive::class)->name('permissions');
        Route::get('/users', UserLive::class)->name('admin.users');
        Route::get('/departments', DepartmentLive::class)->name('admin.departments');
        Route::get('/notifications', NotificationLive::class)->name('admin.notifications');
    });

    // Procurement Officer Routes
    Route::middleware(['role:procurement_officer'])->prefix('procurement')->group(function () {
        Route::get('/suppliers', SupplierLive::class)->name('procurement.suppliers');
        Route::get('/purchase-requests', PurchaseRequestLive::class)->name('procurement.requests');
        Route::get('/tenders', TenderLive::class)->name('procurement.tenders');
        Route::get('/tenders/{id}/bids', TenderBidsLive::class)->name('procurement.tenders.bids');
        Route::get('/bids', BidLive::class)->name('procurement.bids');
        Route::get('/purchase-orders', PurchaseOrderLive::class)->name('procurement.orders');
        Route::get('/contracts', ContractLive::class)->name('procurement.contracts');
        Route::get('/shipments', ShipmentLive::class)->name('procurement.shipments');
        Route::get('/inventory', InventoryItemLive::class)->name('procurement.inventory');
    });

    // Department Head Routes
    Route::middleware(['role:department_head'])->prefix('department')->group(function () {
        Route::get('/purchase-requests', PurchaseRequestLive::class)->name('department.requests');
    });

    // Supplier Routes
    Route::middleware(['role:supplier'])->prefix('supplier')->group(function () {
        Route::get('/bids', BidLive::class)->name('supplier.bids');
        Route::get('/my-bids', MyBidsLive::class)->name('supplier.my.bids');
        Route::get('/orders', PurchaseOrderLive::class)->name('supplier.orders');
        Route::get('/invoices', InvoiceLive::class)->name('supplier.invoices');
    });

    // Finance Officer Routes
    Route::middleware(['role:finance_officer'])->prefix('finance')->group(function () {
        Route::get('/invoices', InvoiceLive::class)->name('finance.invoices');
        Route::get('/payments', PaymentLive::class)->name('finance.payments');
    });

    // Shared Routes (Multi-role Access)
    Route::middleware(['role:procurement_officer|department_head|finance_officer'])->group(function () {
        Route::get('/reports', ReportLive::class)->name('reports');
        Route::get('/reports/pdf', ReportsPdfLive::class)->name('reports.pdf');
    });
    

    Route::get('check/supplier',SupplierCheckLive::class)->name('check.supplier');


});


