<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class IllnessCategory extends Model
{
    use HasFactory;

    protected $fillable = ['category_name', 'slug'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            $category->slug = Str::slug($category->category_name);
        });

        static::updating(function ($category) {
            $category->slug = Str::slug($category->category_name);
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
    public function detail()
{
    return $this->hasOne(IllnessCategoryDetail::class, 'category_id');
}
}