<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    // تحديد القناة التي سيتم البث عليها
    public function broadcastOn()
    {
        // هنا يتم بث الرسالة إلى قناة المحادثة المحددة باستخدام conversation_id
        return new Channel('conversation.' . $this->message->conversation_id);
    }

    // البيانات التي سيتم بثها
    public function broadcastWith()
    {
        return [
            'message' => $this->message,
        ];
    }
}
