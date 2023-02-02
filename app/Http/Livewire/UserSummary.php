<?php

namespace App\Http\Livewire;

use App\Models\Challenge;
use App\Models\Game;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserSummary extends Component
{
    protected $games;
    protected $user;
    public $ratio;
    public $all = true;
    public function mount($user, $o = "all")
    {
       $games = Game::all();
        foreach ($games as $game) {
            $game->guesscount = $game->guesses->count();
            $game->save();
        }



        $this->user = User::findOrFail($user);
        if($o == "all"){
            $ngames = User::find($user)->opponentGames()->orderBy('id', 'desc')->limit(20)->pluck('id');
            $chgames = User::find($user)->challenges()->orderBy('id', 'desc')->limit(20)->pluck('challenge_id');

            foreach ($ngames as $game) {
                $this->games[] = Game::find($game);
            }
            foreach ($chgames as $chgame){
                $this->games[] = Challenge::find($chgame);
            }





        }
        else{
            $this->all = false;
            $this->games = $this->user->opponentGames->where('user_id', Auth::id());
        }
        usort($this->games, fn($a, $b) => $a['crated_at'] <=> $b['created_at']);

        $winGames = Game::where('winner_id', $this->user->id)->count() + Challenge::where('winner_id', $this->user->id)->count();
        $lostGames = Game::where('winner_id', '!=', $this->user->id)->where('winner_id', '!=', null)->count() +
            Challenge::where('winner_id', '!=', $this->user->id)->where('winner_id', '!=', null)->count();

        if($winGames + $lostGames == 0){
            $this->ratio = 0;
        }
        else{
            $this->ratio = round(($winGames / ($winGames + $lostGames)) * 100, 1);
        }

    }

    public function render()
    {
        return view('livewire.user-summary', [
            'games' => $this->games,
            'user' => $this->user,
        ]);
    }
}
