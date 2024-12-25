<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderShipmentStatusUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $sender;
    /**
     * Create a new event instance.
     */
    public function __construct($message, $sender)
    {
        $this->message = $message;
        $this->sender = $sender;
        //
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): Channel
    {
        return new Channel('NovaCart');
    }

    public function broadcastAs() {
        return 'OrderShipmentStatusUpdated';
    }
}
