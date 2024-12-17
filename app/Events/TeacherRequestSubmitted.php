<?php
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TeacherRequestSubmitted 
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $notification;

    public function __construct($notification)
    {
        $this->notification = $notification;
    }

    // Define the channel the event will broadcast on
    public function broadcastOn()
    {
        return new Channel('admin-notifications');
    }

    // Data to send with the broadcast
    public function broadcastWith()
    {
        return $this->notification;
    }
}
