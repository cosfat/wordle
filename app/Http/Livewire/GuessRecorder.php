<?php

namespace App\Http\Livewire;

use App\Events\GuessTyped;
use App\Models\Game;
use App\Models\Guess;
use App\Models\Word;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class GuessRecorder extends Component
{
    protected $listeners = ['addGuess'];

    public function addGuess($word, $gameId)
    {
        $wordId = Word::whereName($word)->first()->id;
        $guess = new Guess();
        $guess->word_id = $wordId;
        $guess->game_id = $gameId;
        $guess->save();

        $game = Game::find($gameId);
        GuessTyped::dispatch($game->user_id);
    }
    public function render()
    {
        return view('livewire.guess-recorder');
    }
}
