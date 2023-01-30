<?php

namespace App\Http\Livewire;

use App\Models\Challenge;
use App\Models\Chguess;
use App\Models\Chuser;
use App\Models\Game;
use App\Models\User;
use App\Models\Word;
use Livewire\Component;

class FinishedChallengeGameWatcher extends Component
{
    public $length;
    public $gameId;
    public $word;
    public $wordName;
    public $userName;
    public $userId;
    public $meaning;

    public $guessesCount;
    public $guessesArray;

    public function mount($gameId, $userId = null)
    {
        $game = Challenge::whereId($gameId)->where('winner_id', '!=', null);
        if ($game->exists()) {

            if($userId == null){
                $userId = User::whereId(Challenge::whereId($gameId)->first()->winner_id)->first()->id;
            }
            $this->userId = $userId;
            $game = $game->first();
            $guesses = $game->chguesses()->where('user_id', $userId)->get();
            foreach ($guesses as $guess) {
                $this->guessesArray[] = $guess->word->name;
            }
            $this->guessesCount = $guesses->count();
            $this->length = $game->length;
            $this->gameId = $gameId;
            $this->wordName = $game->word->name;
            $this->userName = User::find($userId)->name;

            $this->meaning = null;

            if (Word::tdk($this->wordName)) {
                $this->meaning = Word::tdk($this->wordName);
            }
        } else {
            session()->flash('message', 'Bu oyunu görme yetkiniz yok.');
            return redirect()->to('/create-game');
        }

    }

    public function render()
    {
        return view('livewire.finished-challenge-game-watcher');
    }
}
