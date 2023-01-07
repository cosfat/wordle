<?php

namespace App\Http\Livewire;

use App\Models\Game;
use Livewire\Component;

class TheGame extends Component
{
    public $gameWord;
    public $gameId;
    public $wordNumber;
    public $word;

    public function editGame($gameId, $word, $wordNumber){
        $theWord = "word_".$wordNumber;
        $game = Game::find($gameId);
        $game->$theWord = $word;
        $game->save();
    }

    public function render()
    {
        $game = Game::find($this->gameId);
        $game->seen = 1;
        $game->save();
        return view('livewire.the-game');
    }
}
