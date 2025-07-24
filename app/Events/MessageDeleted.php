<?php

namespace App\Events;

use App\Models\ChatMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
// MessageDeleted.php
class MessageDeleted implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct(ChatMessage $message)
    {
        $this->message = $message;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('chat.'.$this->message->receiver_id);
    }
// In MessageDeleted.php
public function broadcastWith()
{
    return [
        'message_id' => $this->message->id,
        'sender_id' => $this->message->sender_id,
        'receiver_id' => $this->message->receiver_id,
        'deleted_for_sender' => $this->message->deleted_for_sender,
        'deleted_for_receiver' => $this->message->deleted_for_receiver
    ];
}
}