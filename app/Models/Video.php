<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    //
    //
    protected $fillable = [
        'title', 
        'description',
        'video_url',
        'video_public_id',
        'thumbnail_url'
    ];
}
