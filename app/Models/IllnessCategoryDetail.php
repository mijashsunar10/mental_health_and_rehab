<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IllnessCategoryDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'hero_image',
        'overview',
        'symptoms',
        'types',
        'treatment',
        'prevention'
    ];

    public function category()
    {
        return $this->belongsTo(IllnessCategory::class);
    }
}