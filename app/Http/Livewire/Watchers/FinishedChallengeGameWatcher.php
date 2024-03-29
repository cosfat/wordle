<?php

namespace App\Http\Livewire\Watchers;

use App\Models\Challenge;
use App\Models\Chguess;
use App\Models\Chuser;
use App\Models\Game;
use App\Models\User;
use App\Models\Word;
use Carbon\CarbonInterval;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
    public $point;
    public $duration;
    public $words;

    public $guessesCount;
    public $guessesArray;
    public $rightGuessString;

    public $chat = false;

    protected $listeners = ['refreshChallengeGameWatcher'];

    public function refreshChallengeGameWatcher(){
        return redirect(request()->header('Referer'));
    }

    public function mount($gameId, $userId = null)
    {
        $game = Challenge::whereId($gameId);
        if ($game->exists()) {
            if(Chuser::where('challenge_id', $gameId)->where('user_id', Auth::id())->exists()){
                $this->chat = true;
            }
            $game = $game->first();
            $this->words = DB::select(DB::raw("SELECT id, name, CHAR_LENGTH(name) AS 'chrlen' FROM words WHERE CHAR_LENGTH(name) = $game->length AND meaning != 'null' ORDER BY RAND() "));

            $this->rightGuessString = $game->word->name;
            $myGuesses = Chguess::where('user_id', Auth::id())->where('challenge_id', $game->id)->count();
            if($myGuesses > $game->length OR $game->winner_id != null){
            if ($userId == null) {
                if($game->winner_id == null){
                    $userId = Auth::id();
                }
                else{
                    $userId = $game->winner_id;
                }
            }
            $length = $game->length;
            $guesses = $game->chguesses()->where('user_id', $userId)->get();
            if($game->winner_id == $userId){
                $this->point = $game->point;
                $this->duration = str_replace('dakika', 'dk', str_replace('saniye', 'sn', CarbonInterval::seconds($game->duration)->cascade()->forHumans()));
            }
            else{
                $this->point = 0;
                $this->duration = "";
            }

                $this->userId = $userId;
                foreach ($guesses as $guess) {
                    $this->guessesArray[] = $guess->word->name;
                }
                $this->guessesCount = $guesses->count();
                $this->length = $length;
                $this->gameId = $gameId;
                $this->wordName = $game->word->name;
                $this->userName = User::find($userId)->name;

                $this->meaning = $game->word->meaning;

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
        return view('livewire.watchers.finished-challenge-game-watcher');
    }
}
