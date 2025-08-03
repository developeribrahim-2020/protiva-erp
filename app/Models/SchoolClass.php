<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * The subjects that belong to the class.
     * এই সম্পর্কটি নিশ্চিত করে যে একটি ক্লাস থেকে তার সব বিষয় খুঁজে পাওয়া যাবে।
     */
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'class_subject');
    }

    /**
     * Get the students for the school class.
     */
    public function students()
    {
        return $this->hasMany(Student::class);
    }
}