<?php

namespace App\Http\Livewire;

use App\Models\Game;
use App\Models\Guess;
use App\Models\User;
use App\Models\Word;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FinishedGameWatcher extends Component
{
    public $length;
    public $gameId;
    public $word;
    public $wordName;
    public $opponentName;
    public $userName;
    public $meaning;

    public $guessesCount;
    public $guessesArray;
    public $chat = false;

    public function mount($gameId)
    {
        $game = Game::whereId($gameId)->where('winner_id', '!=', null);
        if ($game->exists()) {
            $game = $game->first();
            if($game->user_id == Auth::id() OR $game->opponent_id == Auth::id()){
                $this->chat = true;
            }
            $guesses = $game->guesses()->get();
            foreach ($guesses as $guess) {
                $this->guessesArray[] = $guess->word->name;
            }
            $this->guessesCount = $game->guesscount;
            $this->length = $game->length;
            $this->gameId = $gameId;
            $this->wordName = $game->word->name;
            $this->opponentName = User::find($game->user_id)->name;
            $this->userName = User::find($game->opponent_id)->name;

            $this->meaning = null;

            if(Word::tdk($this->wordName)){
                $this->meaning = Word::tdk($this->wordName);
            }
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
