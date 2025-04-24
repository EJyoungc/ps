<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    //
    protected $fillable = [
        'tender_id',
        'supplier_id',
        'amount',
        'proposal',
        'status',
    ];

    public function tender()
    {
        return $this->belongsTo(Tender::class);
    }
    /**
     * Get the supplier that owns the Bid
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
