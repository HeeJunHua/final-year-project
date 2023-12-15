<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodItems extends Model
{
    protected $fillable = [
        'user_id',
        'food_item_name',
        'food_item_category',
        'food_item_quantity',
        'food_item_expiry_date',
        'donated',
    ];

    public function foodDonations()
    {
        return $this->hasMany(FoodDonation::class);
    }

    public function eventRedistributions()
    {
        return $this->hasMany(EventRedistribution::class);
    }

    public function scopeNotDonated($query)
    {
        return $query->where('donated', false);
    }
}
