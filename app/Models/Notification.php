<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'notification_title',
        'notification_content',
        'notification_description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
