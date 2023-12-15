<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vouchers extends Model
{
    protected $fillable = [
        'voucher_code',
        'voucher_name',
        'voucher_description',
        'voucher_point_value',
        'voucher_quantity',
        'voucher_expiry_date',
        'voucher_status',
    ];

    public function redemptions()
    {
        return $this->hasMany(Redemption::class,'voucher_id');
    }
}
