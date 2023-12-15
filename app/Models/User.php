<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'username',
        'contact_number',
        'user_role',
        'user_photo',
        'reset_password_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function announcements()
    {
        return $this->hasMany(Announcement::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function redemptions()
    {
        return $this->hasMany(Redemption::class);
    }

    public function foodDonations()
    {
        return $this->hasMany(FoodDonation::class);
    }

    public function inventory()
    {
        return $this->hasOne(Inventory::class);
    }

    public function eventRedistributions()
    {
        return $this->hasMany(EventRedistribution::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function foodItems(){
        return $this->hasMany(FoodItems::class);
    }
}
