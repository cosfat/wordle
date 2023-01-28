<?php

namespace App\Http\Livewire;

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
        $this->user = User::findOrFail($user);
        if($o == "all"){
            $this->games = $this->user->opponentGames;
        }
        else{
            $this->all = false;
            $this->games = $this->user->opponentGames->where('user_id', Auth::id());
        }

        $winGames = $this->games->where('winner_id', $this->user->id)->count();
        $lostGames = $this->games->where('winner_id', '!=', $this->user->id)->where('winner_id', '!=', null)->count();

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
