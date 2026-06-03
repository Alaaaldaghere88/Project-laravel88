<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class CustomNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $body;
    public $title;

    public function __construct($body, $title)
    {
        $this->body = $body;
        $this->title = $title;
    }
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }
    public function toArray(object $notifiable): array
    {
        return [
            'body' => $this->body,
            'source' => 'system_notification'
        ];
    }
    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'body' => $this->body,
            'title' => $this->title,
        ]);
    }
}
