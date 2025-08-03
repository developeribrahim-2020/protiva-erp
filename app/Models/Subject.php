<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // <-- এই লাইনটি ঠিক করা হয়েছে
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the class that this subject belongs to.
     */
    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class);
    }
}