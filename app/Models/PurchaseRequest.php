<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseRequest extends Model
{
    //
    protected $fillable =[
        'user_id',
        'department_id',
        'items',
        'specifications',
        'estimated_cost',
        'status',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
