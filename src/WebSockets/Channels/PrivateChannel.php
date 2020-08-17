<?php

namespace BeyondCode\LaravelWebSockets\WebSockets\Channels;

use BeyondCode\LaravelWebSockets\Events\UserConnected;
use BeyondCode\LaravelWebSockets\Events\UserDisconnected;
use Ratchet\ConnectionInterface;
use Illuminate\Support\Str;
use stdClass;

class PrivateChannel extends Channel
{
    protected $privateUserChannelPrefix = 'private-user.';

    public function subscribe(ConnectionInterface $connection, stdClass $payload)
    {
        $this->verifySignature($connection, $payload);

        parent::subscribe($connection, $payload);

        if (Str::startsWith($this->channelName, $this->privateUserChannelPrefix)) {
            $userId = Str::after($this->channelName, $this->privateUserChannelPrefix);

            UserConnected::dispatch($userId);
        }
    }

    public function unsubscribe(ConnectionInterface $connection)
    {
        parent::unsubscribe($connection);

        if (Str::startsWith($this->channelName, $this->privateUserChannelPrefix) && !$this->hasConnections()) {
            $userId = Str::after($this->channelName, $this->privateUserChannelPrefix);

            UserDisconnected::dispatch($userId);
        }
    }
}
