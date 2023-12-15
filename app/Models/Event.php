<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'category_id',
        'user_id',
        'event_name',
        'event_description',
        'start_date',
        'end_date',
        'event_location',
        'target_goal',
        'event_status',
        'cover_image',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function announcements()
    {
        return $this->hasMany(Announcement::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function points()
    {
        return $this->hasMany(Point::class);
    }

    public function eventImages()
    {
        return $this->hasMany(EventImage::class);
    }

    public function attachment()
    {
        return $this->hasMany(Attachment::class);
    }

    public function volunteer()
    {
        return $this->hasMany(Volunteer::class);
    }
}
