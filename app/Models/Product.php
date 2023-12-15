<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'product_name',
'inventory_id',
        'product_category',
        'product_description',
        'product_expiry_date',
        'product_quantity',
        'product_status',
    ];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
}
