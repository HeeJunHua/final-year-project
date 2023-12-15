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
        'people_quantity',
        'leftovers_description',
        'status',
        'completed_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function foodItems()
    {
        return $this->morphMany(FoodItems::class, 'itemable');
    }
}
