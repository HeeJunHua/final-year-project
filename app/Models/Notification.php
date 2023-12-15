<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'notification_title',
        'notification_content',
        'notification_read',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function createNotification(User $user, $title, $content)
    {
        $notification = new self([
            'user_id' => $user->id,
            'notification_title' => $title,
            'notification_content' => $content,
        ]);

        $notification->save();

        return $notification;
    }
}
