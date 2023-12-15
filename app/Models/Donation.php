<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $fillable = [
        'event_id',
        'user_id',
        'points_earned',
        'donation_amount',
        'payment_method',
        'donation_date',
        'name',
        'phone',
        'email'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function points()
    {
        return $this->hasMany(Point::class);
    }
}
