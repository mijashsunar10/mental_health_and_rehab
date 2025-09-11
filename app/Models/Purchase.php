<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Purchase extends Model
{
    //
     use HasFactory;

    protected $fillable = [
        'user_id',
        'package_id',
        'selected_option',
        'amount',
        'start_date',
        'end_date',
        'status'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
