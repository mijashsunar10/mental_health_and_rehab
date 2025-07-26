<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorProfile extends Model
{
    
    protected $fillable = [
        'user_id',
        'specializations',
        'qualifications',
        'experience',
        'awards',
        'languages',
        'phone',
        'hospital',
    ];

    /**
     * Get the user that owns the doctor profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
