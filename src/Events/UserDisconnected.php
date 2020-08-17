<?php

namespace BeyondCode\LaravelWebSockets\Events;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserDisconnected implements ShouldQueue
{
    use Dispatchable;
    use SerializesModels;

    /**
     * user's id
     *
     * @var string
     */
    protected $userId;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(string $userId)
    {
        $this->userId = $userId;
    }

    public function getUserId()
    {
        return $this->userId;
    }
}
