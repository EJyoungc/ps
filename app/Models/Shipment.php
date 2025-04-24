<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    //
    protected $fillable = [
        'purchase_order_id',
        'expected_delivery_date',
        'actual_delivery_date',
        'status',
    ];

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }
}
