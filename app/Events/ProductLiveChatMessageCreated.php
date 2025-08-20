<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProductLiveChatMessageCreated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $threadId;
    public string $sender;
    public ?string $message;
    public array $attachments;

    public function __construct(int $threadId, string $sender, ?string $message = null, array $attachments = [])
    {
        $this->threadId = $threadId;
        $this->sender = $sender;
        $this->message = $message;
        $this->attachments = $attachments;
    }

    public function broadcastOn(): Channel
    {
        // Public channel for simplicity. Consider switching to Private/Presence with auth later.
        return new Channel('product-live-chat.' . $this->threadId);
    }

    public function broadcastAs(): string
    {
        return 'plc.message';
    }

    public function broadcastWith(): array
    {
        return [
            'thread_id' => $this->threadId,
            'sender' => $this->sender,
            'message' => $this->message,
            'attachments' => $this->attachments,
            'timestamp' => now()->toDateTimeString(),
        ];
    }
}
