<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    //
    protected $fillable = [
        'purchase_order_id',
        'amount',
        'due_date',
        'status',
    ];
    protected $casts = [
        'due_date' => 'datetime',
    ];
    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }
}
