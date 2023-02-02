<?php

namespace App\Http\Livewire;

use App\Models\Game;
use Livewire\Component;

class Smiley extends Component
{
    public $smiley;
    public $gameId;

    public function mount($gameId)
    {
        $this->gameId = $gameId;
        $game = Game::find($this->gameId);
        if($game->smiley != null)
        {
            $this->smiley = $game->smiley;
        }
    }

    public function change($n)
    {
        $this->smiley = $n;

        $game = Game::find($this->gameId);
        $game->smiley = $n;
        $game->save();

    }

    public function render()
    {
        return view('livewire.smiley');
    }
}
