<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Faq extends Model
{
   protected $fillable = ['question', 'answer', 'slug'];

    
    // Automatically generate a slug from the question
    protected static function boot()
    {
        parent::boot();
        static::saving(function ($faq) {
            $faq->slug = Str::slug($faq->question);
        });
    }
}
