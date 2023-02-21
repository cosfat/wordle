<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GameNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $opp;
    public $game;
    public $username;
    public $type;
    public $previous;
    public $word;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($opp, $game, $username, $type, $previous, $word)
    {
        $this->opp = $opp;
        $this->game = $game;
        $this->username = $username;
        $this->type = $type;
        $this->previous = $previous;
        $this->word = $word;

    }

    /**
     * Get the channels the event should broadcast on.
     *
     *  @return PrivateChannel
     */
    public function broadcastOn()
    {
        return new PrivateChannel('game-channel.'.$this->opp);
    }
}
