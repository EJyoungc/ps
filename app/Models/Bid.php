<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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

    /**
     * Set the user_id attribute to the authenticated user's ID.
     *
     * @param mixed $value
     * @return void
     */
    public function setUserIdAttribute($value)
    {
        $this->attributes['user_id'] = Auth::user()->id();
    }

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
