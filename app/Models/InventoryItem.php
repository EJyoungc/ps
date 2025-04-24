<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    //
    protected $fillable = [

        'name',
        'description',
        'current_stock',
        'minimum_stock',
        'unit_of_measure',
    ];

}
