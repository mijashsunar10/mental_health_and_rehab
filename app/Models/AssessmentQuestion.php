<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentQuestion extends Model
{
    protected $fillable = ['category', 'question', 'order'];

public function responses()
{
    return $this->hasMany(UserResponse::class, 'question_id');
}
}
