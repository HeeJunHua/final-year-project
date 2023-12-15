<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodBank extends Model
{
    protected $fillable = [
        'name',
        'address',
        'latitude',
        'longitude',
        'phone_number',
    ];
    
}