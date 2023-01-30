<?php

namespace App\Http\Livewire;

use App\Models\Challenge;
use App\Models\Chguess;
use App\Models\Chuser;
use App\Models\Game;
use App\Models\User;
use App\Models\Word;
use Illuminate\Support\Facades\Auth;
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
        $game = Challenge::whereId($gameId);
        if ($game->exists()) {

            $game = $game->first();
            $myGuesses = Chguess::where('user_id', Auth::id())->where('challenge_id', $game->id)->count();
            if($myGuesses > $game->length OR $game->winner_id != null){
            if ($userId == null) {
                if($game->winner_id == null){
                    $userId = Auth::id();
                }
                else{
                    $userId = User::whereId($game->first()->winner_id)->first()->id;
                }
            }
            $length = $game->length;
            $guesses = $game->chguesses()->where('user_id', $userId)->get();


                $this->userId = $userId;
                foreach ($guesses as $guess) {
                    $this->guessesArray[] = $guess->word->name;
                }
                $this->guessesCount = $guesses->count();
                $this->length = $length;
                $this->gameId = $gameId;
                $this->wordName = $game->word->name;
                $this->userName = User::find($userId)->name;

                $this->meaning = null;

                if (Word::tdk($this->wordName)) {
                    $this->meaning = Word::tdk($this->wordName);
                }
            } else {
                session()->flash('message', 'Önce oyunu bitirmeniz gerekir');
                return redirect()->to('/create-game');
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
