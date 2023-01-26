<?php

namespace App\Http\Livewire;

use App\Models\Game;
use App\Models\Guess;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FinishedGameWatcher extends Component
{
    public $length;
    public $gameId;
    public $word;
    public $wordName;
    public $opponentName;

    public $guessesCount;
    public $guessesArray;

    public function mount($gameId)
    {
        $game = Game::whereId($gameId)->where('opponent_id', Auth::id())->where('winner_id', '!=', null);
        if ($game->exists()) {
            $game = $game->first();
            $guesses = $game->guesses()->get();
            foreach ($guesses as $guess) {
                $this->guessesArray[] = $guess->word->name;
            }
            $this->guessesCount = $guesses->count();
            $this->length = $game->length;
            $this->gameId = $gameId;
            $this->wordName = $game->word->name;
            $this->opponentName = User::find($game->user_id)->name;
        } else {
            session()->flash('message', 'Bu oyunu görme yetkiniz yok.');
            return redirect()->to('/create-game');
        }

    }


    public function render()
    {
        return view('livewire.finished-game-watcher');
    }
}
