<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserTyping implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public int $caseId,
        public int $userId,
        public string $userName,
        public string $role,
        public bool $typing
    ) {
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('case.' . $this->caseId),
        ];
    }

    public function broadcastAs(): string
    {
        return 'user.typing';
    }

    public function broadcastWith(): array
    {
        return [
            'case_id' => $this->caseId,
            'user_id' => $this->userId,
            'user_name' => $this->userName,
            'role' => $this->role,
            'typing' => $this->typing,
        ];
    }
}
