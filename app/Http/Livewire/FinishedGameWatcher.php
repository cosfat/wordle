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
    public $userName;
    public $meaning;

    public $guessesCount;
    public $guessesArray;

    public function mount($gameId)
    {
        $game = Game::whereId($gameId)->where('winner_id', '!=', null);
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
            $this->userName = User::find($game->opponent_id)->name;

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


    public function render()
    {
        return view('livewire.finished-game-watcher');
    }
}
