<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tender extends Model
{
    protected $fillable = [
        'title',
        'description',
        'deadline',
        'status',

    ];


    protected $casts = [
        'deadline' => 'datetime',
    ];


}
