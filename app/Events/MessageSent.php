<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The message that was sent.
     */
    public function __construct(
        public Message $message
    ) {}

    /**
     * The channel where the event should be broadcast.
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel(
                'case.' . $this->message->case_id
            ),
        ];
    }

    /**
     * The name of the broadcast event.
     */
    public function broadcastAs(): string
    {
        return 'message.sent';
    }

    /**
     * The data sent to the frontend.
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->message->id,
            'case_id' => $this->message->case_id,
            'sender_id' => $this->message->sender_id,
            'sender' => $this->message->sender->name,
            'receiver_id' => $this->message->receiver_id,
            'subject' => $this->message->subject,
            'content' => $this->message->content,
            'is_new' => $this->message->is_new,
            'created_at' => $this->message->created_at?->toISOString(),
        ];
    }
}
