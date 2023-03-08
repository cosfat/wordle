<?php

namespace App\Http\Livewire\Games;

use App\Events\GuessTyped;
use App\Models\Challenge;
use App\Models\Game;
use App\Models\Guess;
use App\Models\Point;
use App\Models\User;
use App\Models\Word;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Carbon\Carbon;

class TheGame extends Component
{
    public $length;
    public $gameId;
    public $wordName;
    public $opponentName;
    public $myOpp;
    public $start;
    public $firstGuess = false;

    public $guessesCount;
    public $guessesArray;

    public $isDuello = 0;
    public $sira = null;
    public $chatcode;

    public $frequents = array();

    protected $listeners = ['loser', 'winner'];


    public function mount($gameId, $duello = 0)
    {
        if ($duello == 1) {
            $this->isDuello = 1;
            $game = Game::find($gameId);
            $this->wordName = $game->word->name;
            if ($game != null) {
                if ($game->user_id == Auth::id() or $game->opponent_id == Auth::id()) {
                    if($game->winner_id != null){
                        return redirect()->to('/finished-game-watcher/'.$game->id);
                    }
                    else{
                        $guesses = $game->guesses()->get();
                        if ($guesses->count() == 0) {
                            $this->firstGuess = true;
                        }
                        foreach ($guesses as $guess) {
                            $this->guessesArray[] = $guess->word->name;
                        }
                        $this->guessesCount = $game->guesscount;

                        $this->gameId = $gameId;
                        $this->length = $game->length;
                        $this->frequents = $this->frequentWords();
                        $this->chatcode = $game->chatcode;
                        if ($game->user_id == Auth::id()) {
                            $opponent = User::find($game->opponent_id);
                            $this->opponentName = $opponent->username;
                            $this->myOpp = $opponent->id;

                        } else {
                            $opponent = User::find($game->user_id);
                            $this->opponentName = $opponent->username;
                            $this->myOpp = $opponent->id;
                        }
                        $this->sira = $game->sira;
                    }

                } else {
                    session()->flash('message', 'Bu oyunu görme yetkiniz yok');
                    return redirect()->to('/create-game');
                }
            }
            else{
                session()->flash('message', 'Bu oyunu görme yetkiniz yok');
                return redirect()->to('/create-game');
            }

        } else {
            $game = Game::whereId($gameId)->where('opponent_id', Auth::id());
            if ($game->exists()) {
                $game = $game->first();
                $this->wordName = $game->word->name;
                $this->chatcode = $game->chatcode;
                $guesses = $game->guesses()->get();
                if ($guesses->count() == 0) {
                    $this->firstGuess = true;
                }
                foreach ($guesses as $guess) {
                    $this->guessesArray[] = $guess->word->name;
                }
                $this->guessesCount = $game->guesscount;

                $this->gameId = $gameId;
                $this->length = $game->length;
                $this->frequents = $this->frequentWords();
                $opponent = User::find($game->user_id);
                $this->opponentName = $opponent->username;
                $this->myOpp = $opponent->id;

            } else {
                session()->flash('message', 'Bu oyunu görme yetkiniz yok.');
                return redirect()->to('/create-game');
            }
        }
    }


    public function winner()
    {
        $game = Game::find($this->gameId);
        if($this->isDuello == 1){
            $game->winner_id = Auth::id();
        }
        else{
            $game->winner_id = $game->opponent_id;
        }
        $degree = ($game->length - $game->guesscount + 3) * 5;

        if ($game->user_id == 2) {
            $degree = $degree * 2;
        }
        if ($game->guesses()->count() == 1) {
            $duration = $game->created_at->diffInSeconds($game->guesses()->first()->created_at);
        } else {
            $first = $game->guesses()->orderBy('id', 'asc')->first()->created_at;
            $last = $game->guesses()->orderBy('id', 'desc')->first()->created_at;
            $duration = $first->diffInSeconds($last);
        }
        $durationPoint = round(500 / $duration);
        $point = Point::whereUser_id($game->opponent_id);
        if ($point->exists()) {
            $point = $point->first();
            $point->point = $point->point + $degree + $durationPoint;
        } else {
            $point = new Point;
            $point->user_id = $game->winner_id;
            $point->point = $degree + $durationPoint;
        }


        $game->degree = $degree + $durationPoint;
        $game->duration = $duration;
        $game->save();
        $point->save();

        if($this->isDuello == 1){
            if($game->user_id == Auth::id()){
                $opp = $game->opponent_id;
            }
            else{
                $opp = $game->user_id;
            }
            GuessTyped::dispatch($opp, $game->id, Auth::user()->username, 5, Auth::id(), 1, 0);
        }
        else{
            GuessTyped::dispatch($game->user_id, $game->id, Auth::user()->username, 3, Auth::id(), 0, 0);
        }
        return redirect('/finished-game-watcher/' . $this->gameId);
    }


    public function loser()
    {
        if($this->isDuello == 1){
            $game = Game::find($this->gameId);
            $game->winner_id = 0;
            $first = $game->guesses()->orderBy('id', 'asc')->first()->created_at;
            $last = $game->guesses()->orderBy('id', 'desc')->first()->created_at;
            $game->duration = $first->diffInSeconds($last);
            $game->save();
            return redirect('/finished-game-watcher/' . $this->gameId);
        }
        else{

            $game = Game::whereId($this->gameId)->first();
            $game->winner_id = $game->user_id;
            $game->degree = (8 - $game->length);
            $first = $game->guesses()->orderBy('id', 'asc')->first()->created_at;
            $last = $game->guesses()->orderBy('id', 'desc')->first()->created_at;
            $game->duration = $first->diffInSeconds($last);
            $game->save();

            $point = Point::whereUser_id($game->user_id);
            if ($point->exists()) {
                $point = $point->first();
                $previous = $point->point;
                $new = $game->degree;
                $total = $previous + $new;
                $point->point = $total;
                $point->save();
            } else {
                $point = new Point;
                $point->user_id = $game->user_id;
                $point->point = $game->degree;;
                $point->save();

            }
            return redirect('/finished-game-watcher/' . $this->gameId);
        }
    }


    public function frequentWords(){

        $guessesX = array();
        $games = Auth::user()->opponentGames()->where('length', $this->length)->orderBy('id', 'desc')->limit(10)->get();
        $chGames = Challenge::where('user_id', Auth::id())->where('length', $this->length)->orderBy('id', 'desc')->limit(10)->get();
        foreach ($games as $game) {
            if($game->guesses()->first() != null){
                $guessesX[] = $game->guesses()->first()->word->name;
            }
        }


        foreach ($chGames as $chGame) {
            $guess = $chGame->chguesses()->where('user_id', Auth::id())->first();
            if($guess != null)
            {
                $guessesX[] = $guess->word->name;
            }
        }

        $values = array_count_values($guessesX);
        arsort($values);
        return array_slice(array_keys($values), 0, 5, true);

    }

    public function render()
    {
        $game = Game::find($this->gameId);
        $first = $game->guesses()->first();
        if ($first != null) {
            $this->start = $first->created_at->diffInSeconds(Carbon::now());
        } else {
            $this->start = 0;
        }
        if($this->isDuello == 1){
            if($game->opponent_id == Auth::id()){
                $game->seen = 1;
            }
        }
        else{
            $game->seen = 1;
        }
        $game->save();
        return view('livewire.games.the-game');
    }
}
