<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //
    protected $fillable = [
        'invoice_id',
        'amount',
        'payment_date',
        'reference_number',
    ];

    protected $casts = [
        'payment_date' => 'datetime',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
    /**
     * Get the purchase order that owns the Payment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }
}
