<?php

// app/Models/DoctorProfile.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'specialization',
        'qualifications',
        'experience',
        'bio',
        'phone',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'photo',
        'working_days',
        'start_time',
        'end_time'
    ];

    protected $casts = [
        'working_days' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
