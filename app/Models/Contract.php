<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    //
    protected $fillable = [
        'purchase_order_id',
        'supplier_id',
        'start_date',
        'end_date',
        'terms',
        'renewal_alert_sent',
    ];

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
