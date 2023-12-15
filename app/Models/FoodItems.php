<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodItems extends Model
{
    protected $fillable = [
        'user_id',
        'food_donation_id',
        'food_item_name',
        'food_item_category',
        'food_item_quantity',
        'has_expiry_date',
        'food_item_expiry_date',
        'donated',
        'itemable_id',
        'itemable_type',
    ];

    // Polymorphic relationship
    public function itemable()
    {
        return $this->morphTo();
    }
    

    public function scopeNotDonated($query)
    {
        return $query->where('donated', false);
    }
}
