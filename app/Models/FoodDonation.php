<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodDonation extends Model
{
    protected $fillable = [
        'user_id',
        'food_donation_date',
        'food_donation_status',
        'total_quantity',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getTotalQuantityAttribute()
    {
        return $this->foodItems()->sum('food_item_quantity');
    }

    public function foodItems()
    {
        return $this->morphMany(FoodItems::class, 'itemable');
    }

    public function foodBank()
    {
        return $this->belongsTo(FoodBank::class, 'food_bank_id', 'id'); 
    }
}
