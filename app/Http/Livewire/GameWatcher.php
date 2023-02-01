<?php

namespace App\Http\Livewire;

use App\Models\Game;
use App\Models\Guess;
use App\Models\User;
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
            $guesses = $game->guesses()->get();
            $lastGuess = $game->guesses()->orderBy('id', 'desc');
            if($lastGuess->exists()){
                $this->lastGuessTime = $lastGuess->first()->created_at->diffForHumans();
                $last = $lastGuess->first();
                $last->seen = 1;
                $last->save();

            }

            foreach ($guesses as $guess) {
                $this->guessesArray[] = $guess->word->name;
            }
            $this->guessesCount = $guesses->count();
            $this->length = $game->length;
            $this->gameId = $gameId;
            $this->wordName = $game->word->name;
            $this->opponentName = User::find($game->opponent_id)->name;


            $url = "https://sozluk.gov.tr/gts?ara=".$this->wordName;

            $json = json_decode(file_get_contents($url), true);

            if(isset($json["error"])){
                $this->meaning = null;
            }
            else{

                $this->meaning = $json[0]['anlamlarListe'][0]['anlam'];
            }
        } else {
            session()->flash('message', 'Bu oyunu görme yetkiniz yok.');
            return redirect()->to('/create-game');
        }

    }

    public function editGame($gameId, $word, $wordNumber)
    {
        $theWord = "word_" . $wordNumber;
        $game = Game::find($gameId);
        $game->$theWord = $word;
        $game->save();
    }

    public function render()
    {
        return view('livewire.game-watcher');
    }
}
