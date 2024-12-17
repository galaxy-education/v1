<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SessionStarted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $appointmentId;

    public function __construct($appointmentId)
    {
        $this->appointmentId = $appointmentId;
    }

    public function broadcastOn()
    {
        return new Channel('appointments.' . $this->appointmentId);
    }
}
