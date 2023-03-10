<?php

namespace App\Http\Livewire\Watchers;

use App\Models\Game;
use App\Models\Guess;
use App\Models\Today;
use App\Models\User;
use App\Models\Word;
use Carbon\CarbonInterval;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Orhanerday\OpenAi\OpenAi;

class FinishedGameWatcher extends Component
{
    public $length;
    public $gameType;
    public $gameId;
    public $word;
    public $wordName;
    public $opponentName;
    public $userName;
    public $meaning;
    public $point;
    public $myOpp = false;

    public $guessesCount;
    public $guessesArray;
    public $chat = false;
    public $isDuello = null;
    public $winner;
    public $chatCode;
    public $todayRank;

    public function mount($gameId)
    {
        $game = Game::whereId($gameId)->where('winner_id', '!=', null);
        if ($game->exists()) {
            $game = $game->first();
            $this->chatcode = $game->chatcode;
            $this->isDuello = $game->isduello;
            if ($game->user_id == Auth::id() or $game->opponent_id == Auth::id()) {
                $this->chat = true;
                if ($game->user_id == Auth::id()) {
                    $this->myOpp = $game->opponent_id;
                } else {
                    $this->myOpp = $game->user_id;
                }
            }

            if ($game->user_id == 2) {
                $today = Today::orderBy('id', 'desc')->first()->id;
                if ($game->today_id == $today) {
                    if (Auth::user()->opponentGames()->where('today_id', $today)->whereNull('winner_id')->exists()) {
                        session()->flash('message', 'Önce günün kelimesini çözmelisin.');
                        return redirect()->to('/my-games');
                    }
                }
                $this->chat = true;
                $this->gameType = $game->today_id;
                if ($game->opponent_id != Auth::id()) {
                    $this->myOpp = $game->opponent_id;
                }
                $this->todayRank = Game::getTodayRanking($game->today_id, $game->opponent_id);
            } else {
                $this->gameType = 1;
            }
            $guesses = $game->guesses()->get();
            foreach ($guesses as $guess) {
                $this->guessesArray[] = $guess->word->name;
            }
            $this->point = $game->degree;
            $this->guessesCount = $game->guesscount;
            $this->length = $game->length;
            $this->gameId = $gameId;
            $this->wordName = $game->word->name;

            $this->opponentName = User::find($game->user_id)->name;
            $this->userName = User::find($game->opponent_id)->name;


            if($game->winner_id != 0){
                $this->winner = User::find($game->winner_id)->username;
            }
            else{
                $this->winner = "Kimse kazanamadı";
            }

            $this->duration = str_replace('dakika', 'dk', str_replace('saniye', 'sn', CarbonInterval::seconds($game->duration)->cascade()->forHumans()));

            $this->meaning = $game->word->meaning;
        } else {
            session()->flash('message', 'Bu oyunu görme yetkiniz yok.');
            return redirect()->to('/create-game');
        }

    }

    public function render()
    {
        return view('livewire.watchers.finished-game-watcher');
    }
}
