<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventRedistribution extends Model
{
    protected $fillable = [
        'user_id',
        'event_name',
        'event_date',
        'location',
        'food_amount_unit',
        'food_amount',
        'people_quantity',
        'leftovers_description',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
