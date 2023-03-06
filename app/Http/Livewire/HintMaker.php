<?php

namespace App\Http\Livewire;

use App\Models\Game;
use Livewire\Component;

class HintMaker extends Component
{
    public $gameId;
    public function mount(){
        $game = Game::find($this->gameId);
        $word = $game->word->name;
        $guesses = $game->guesses();
        foreach ($guesses as $guess) {

        }
    }

    public function render()
    {
        return view('livewire.hint-maker');
    }
}
