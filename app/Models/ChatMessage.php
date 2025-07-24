<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChatMessage extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'sender_id', 
        'receiver_id', 
        'message', 
        'reply_to',
        'image_path',
        'deleted_for_sender',
        'deleted_for_receiver',
        'edited_at'
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function repliedMessage()
    {
        return $this->belongsTo(ChatMessage::class, 'reply_to');
    }

    public function replies()
    {
        return $this->hasMany(ChatMessage::class, 'reply_to');
    }

    public function isImage()
    {
        return !is_null($this->image_path);
    }
}