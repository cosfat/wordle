<?php

namespace App\Http\Livewire;

use App\Models\Challenge;
use App\Models\Chguess;
use App\Models\Chuser;
use App\Models\Game;
use App\Models\Guess;
use App\Models\Point;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TheChallengeGame extends Component
{
    public $length;
    public $gameId;
    public $word;
    public $opponents = array();

    public $guessesCount;
    public $guessesArray;

    protected $listeners = ['chWinner', 'chLoser'];


    public function chWinner()
    {
        $userId = Auth::id();
        $game = Challenge::whereId($this->gameId)->first();

        if (Chuser::where('user_id', Auth::id())->where('challenge_id', $this->gameId)->exists()) {
            if (Challenge::whereId($this->gameId)->where('winner_id', null)->exists()) {

                $game->winner_id = $userId;
                $game->point = ($game->length - Chguess::whereChallenge_id($this->gameId)->where('user_id', $userId)->count() + 2) * 10;
                $game->save();

                $point = Point::whereUser_id($userId);
                if($point->exists()){
                    $point = $point->first();
                    $point->point = $point->point + $game->point;
                    $point->save();
                }
                else {
                    $point = new Point;
                    $point->user_id = $userId;
                    $point->point = $game->point;;
                    $point->save();
                }
                return redirect('/finished-challenge-game-watcher/'.$this->gameId);
            }
            else{
                return redirect('/finished-challenge-game-watcher/' . $this->gameId);
            }
        }
        else{
            session()->flash('message', 'Bu oyunu görme yetkiniz yok.');
            return redirect()->to('/create-game');
        }

    }

    public function chLoser()
    {
        return redirect('/finished-challenge-game-watcher/'.$this->gameId);
    }


    public function mount($gameId)
    {
        if(Chuser::where('user_id', Auth::id())->where('challenge_id', $gameId)->exists())
        {
            if(Challenge::whereId($gameId)->where('winner_id', null)->exists()){

                $game = Challenge::whereId($gameId)->first();

                $guesses = Chguess::where('challenge_id', $game->id)->where('user_id', Auth::id())->get();
                foreach ($guesses as $guess) {
                    $this->guessesArray[] = $guess->word->name;
                }

                $this->guessesCount = $guesses->count();

                $this->gameId = $gameId;
                $this->length = $game->length;
                foreach ($game->chusers as $chuser) {
                    $this->opponents[] = User::whereId($chuser->user_id)->first()->name;
                }
            }
            else{
                return redirect('/finished-challenge-game-watcher/'.$this->gameId);
            }

        } else {
            session()->flash('message', 'Bu oyunu görme yetkiniz yok.');
            return redirect()->to('/create-game');
        }

    }

    public function render()
    {
        $chuser = Chuser::where('challenge_id', $this->gameId)->where('user_id', Auth::id())->first();
        $chuser->seen = 1;
        $chuser->save();
        return view('livewire.the-challenge-game');
    }
}
