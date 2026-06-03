<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendNotificationMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $body;
    public $title;
    public $userIds;

    public function __construct($userIds, $body, $title)
    {
        $this->userIds = collect($userIds)->toArray();

        $this->body = $body;
        $this->title = $title;
    }

    public function broadcastOn(): array
    {
        return collect($this->userIds)
            ->map(function ($id) {
                return new PrivateChannel(
                    'user.notifications.' . $id
                );
            })
            ->toArray();
    }

    public function broadcastWith(): array
    {
        return [
            'body' => $this->body,
            'title' => $this->title,
        ];
    }
}
