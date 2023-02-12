<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GuessTyped implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $opp;
    public $game;
    public $username;
    public $type;
    public $userId;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($opp, $game, $username, $type, $userId)
    {
        $this->opp = $opp;
        $this->game = $game;
        $this->username = $username;
        $this->type = $type;
        $this->userId = $userId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('guesses-channel.'.$this->opp);
    }
}
