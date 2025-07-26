<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
     use HasFactory;

    protected $fillable = [
        'user_id',
        'package_id',
        'option_index',
        'amount',
        'customer_name',
        'customer_email',
        'payment_reference',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
