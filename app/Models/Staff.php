<?php
namespace App\Models; // <-- এখানে হাইফেনের পরিবর্তে ব্যাকস্ল্যাশ হবে

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the user record associated with the staff member.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}