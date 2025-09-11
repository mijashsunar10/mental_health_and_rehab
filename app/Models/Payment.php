<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Payment extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'purchase_id',
        'payment_method',
        'transaction_id',
        'amount',
        'status',
        'payment_details'
    ];

    protected $casts = [
        'payment_details' => 'array'
    ];

    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchase::class);
    }
}
