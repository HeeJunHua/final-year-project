<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompletionForm extends Model
{
    use HasFactory;

    public function volunteer()
    {
        return $this->belongsTo(Volunteer::class);
    }
}
