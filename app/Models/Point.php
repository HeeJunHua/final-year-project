<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    protected $fillable = [
        'event_id',
        'user_id',
        'donation_id',
        'redemption_id',
        'point',
        'transaction_type'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function donation()
    {
        return $this->belongsTo(Donation::class);
    }

    public function redemption()
    {
        return $this->belongsTo(Redemption::class);
    }
}
