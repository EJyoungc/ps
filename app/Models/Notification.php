<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Notification extends Model
{
    //


    protected $fillable = [
        'user_id',
        'type',
        'notifiable_id',
        'notifiable_type',
        'message',
        'read',
    ];

    /**
     * Get the parent notifiable model.
     */
    public function notifiable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Mark this notification as read.
     */
    public function markAsRead(): void
    {
        $this->update(['read' => true]);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
