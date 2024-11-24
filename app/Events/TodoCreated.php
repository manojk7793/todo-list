<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TodoCreated implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $content;

    public function __construct($content)
    {
        $this->content = $content;
        \Log::info('TodoCreated Event Constructed:', ['content' => $this->content]);
    }

    public function broadcastOn()
    {
        \Log::info('Broadcasting on Channel:', ['channel' => 'todo-channel']);
        return new Channel('todo-channel');
    }

    public function broadcastWith()
    {
        \Log::info('Broadcasting Payload:', ['content' => $this->content]);
        return [
            'content' => $this->content,
        ];
    }
}
