<?php

namespace App\Http\Livewire\Watchers;

use App\Models\Game;
use App\Models\Guess;
use App\Models\User;
use App\Models\Word;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class GameWatcher extends Component
{
    public $length;
    public $gameId;
    public $word;
    public $wordName;
    public $opponentName;
    public $lastGuessTime = "tahmin yok";
    public $meaning;
    public $myOpp;

    public $guessesCount;
    public $guessesArray;
    protected $listeners = ['refreshGameWatcher'];

    public function refreshGameWatcher(){
        return redirect(request()->header('Referer'));
    }

    public function mount($gameId)
    {
        $game = Game::whereId($gameId)->where('user_id', Auth::id());
        if ($game->exists()) {
            $game = $game->first();
            $game->seen2 = 1;
            $game->save();
            $guesses = $game->guesses()->get();
            $lastGuess = $game->guesses()->orderBy('id', 'desc');
            if($lastGuess->exists()){
                $this->lastGuessTime = $lastGuess->first()->created_at->diffForHumans();
            }

            foreach ($guesses as $guess) {
                $this->guessesArray[] = $guess->word->name;
            }
            $this->guessesCount = $game->guesscount;
            $this->length = $game->length;
            $this->gameId = $gameId;
            $this->wordName = $game->word->name;
            $opponent = User::find($game->opponent_id);
            $this->opponentName = $opponent->name;
            $this->myOpp = $opponent->id;

            $this->meaning = $game->word->meaning;
            if($this->meaning == ""){
                $this->meaning = Word::tdk($this->wordName);
            }
        } else {
            session()->flash('message', 'Bu oyunu görme yetkiniz yok.');
            return redirect()->to('/create-game');
        }

    }

    public function render()
    {
        return view('livewire.watchers.game-watcher');
    }
}
