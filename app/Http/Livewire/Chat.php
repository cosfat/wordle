<?php

namespace App\Http\Livewire;

use App\Models\Challenge;
use App\Models\Game;
use Livewire\Component;

class Chat extends Component
{
    protected $messages;

    public $gameId;
    public $gameType;

    public function render()
    {
        $this->messages = Chat::where('game_id', $this->gameId)->where('game_type', $this->gameType)->orderBy('id', 'desc')->limit(5)->get();

        return view('livewire.chat', [
            'messages' => $this->messages
        ]);
    }
}
