<?php

namespace App\Http\Livewire\Games;

use App\Events\GuessTyped;
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
    public $word;
    public $opponentName;
    public $start;
    public $firstGuess = false;

    public $guessesCount;
    public $guessesArray;

    protected $listeners = ['loser', 'winner'];

    public function mount($gameId)
    {
        $game = Game::whereId($gameId)->where('opponent_id', Auth::id());
        if ($game->exists()) {
            $game = $game->first();
            $guesses = $game->guesses()->get();
            if($guesses->count() == 0){
                $this->firstGuess = true;
            }
            foreach ($guesses as $guess) {
                $this->guessesArray[] = $guess->word->name;
            }
            $this->guessesCount = $game->guesscount;

            $this->gameId = $gameId;
            $this->length = $game->length;
            $this->opponentName = User::find($game->user_id)->name;

        } else {
            session()->flash('message', 'Bu oyunu görme yetkiniz yok.');
            return redirect()->to('/create-game');
        }
    }


    public function winner()
    {
        $game = Game::whereId($this->gameId)->first();
        $game->winner_id = $game->opponent_id;
        $degree = ($game->length - $game->guesscount + 3) * 5;

        if($game->user_id == 2){
            $degree = $degree * 2;
        }
        if($game->guesses()->count() == 1){
            $duration = $game->created_at->diffInSeconds($game->guesses()->first()->created_at);
        }
        else{
            $first = $game->guesses()->orderBy('id', 'asc')->first()->created_at;
            $last = $game->guesses()->orderBy('id', 'desc')->first()->created_at;
            $duration = $first->diffInSeconds($last);
        }
        $durationPoint = round(500 / $duration);
        $point = Point::whereUser_id($game->opponent_id);
        if($point->exists()){
            $point = $point->first();
            $point->point = $point->point + $degree + $durationPoint;
        }
        else {
            $point = new Point;
            $point->user_id = $game->winner_id;
            $point->point = $degree + $durationPoint;
        }


        $game->degree = $degree + $durationPoint;
        $game->duration = $duration;
        $game->save();
        $point->save();

        GuessTyped::dispatch($game->user_id, $game->id, Auth::user()->username, 3, Auth::id());
        return redirect('/finished-game-watcher/'.$this->gameId);
    }


    public function loser()
    {
        $game = Game::whereId($this->gameId)->first();
        $game->winner_id = $game->user_id;
        $game->degree = (8 - $game->length);
        $first = $game->guesses()->orderBy('id', 'asc')->first()->created_at;
        $last = $game->guesses()->orderBy('id', 'desc')->first()->created_at;
        $game->duration = $first->diffInSeconds($last);
        $game->save();

        $point = Point::whereUser_id($game->user_id);
        if($point->exists())
        {
            $point = $point->first();
            $previous = $point->point;
            $new = $game->degree;
            $total = $previous + $new;
            $point->point = $total;
            $point->save();
        }
        else {
            $point = new Point;
            $point->user_id = $game->user_id;
            $point->point = $game->degree;;
            $point->save();

        }
        return redirect('/finished-game-watcher/'.$this->gameId);
    }


    public function render()
    {
        $game = Game::find($this->gameId);
        $first = $game->guesses()->first();
        if($first != null){
            $this->start = $first->created_at->diffInSeconds(Carbon::now());
        }
        else{
            $this->start = 0;
        }
        $game->seen = 1;
        $game->save();
        return view('livewire.games.the-game');
    }
}
