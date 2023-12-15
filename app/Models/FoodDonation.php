<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodDonation extends Model
{
    protected $fillable = [
        'user_id',
        'food_item_id',
        'food_donation_date',
        'food_donation_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function foodItem()
    {
        return $this->belongsTo(FoodItems::class);
    }
}
