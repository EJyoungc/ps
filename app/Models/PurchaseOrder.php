<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    //
    protected $fillable = [
        'purchase_request_id',
        'supplier_id',
        'po_number',
        'delivery_date',
        'status',
    ];

    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }

    public function purchaseRequest(){
        return $this->belongsTo(PurchaseRequest::class);
    }
    
    
    protected $casts = [
        'delivery_date' => 'date',
    ];
}
