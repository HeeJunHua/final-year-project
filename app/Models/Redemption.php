<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Redemption extends Model
{
    protected $fillable = [
        'voucher_id',
        'user_id',
        'redemption_date',
        'redeemed_points',
    ];

    public function voucher()
    {
        return $this->belongsTo(Vouchers::class);
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
