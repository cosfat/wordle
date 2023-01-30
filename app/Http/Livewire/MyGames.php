<?php

namespace App\Http\Livewire;

use App\Models\Challenge;
use App\Models\Chuser;
use App\Models\Game;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MyGames extends Component
{
    public $gameId;

    protected $listeners = ['MyGames' => 'getGames'];
    protected $gamesMe;
    protected $gamesOp;
    protected $gamesCh;

    public function getGames(){
        $this->gamesMe = Game::where('user_id', Auth::id())->where('winner_id', null)->orderBy('updated_at', 'desc')->get();
        $this->gamesOp = Game::where('opponent_id', Auth::id())->where('winner_id', null)->orderBy('updated_at', 'desc')->get();
        $this->gamesCh = Chuser::where('user_id', Auth::id())->orderBy('updated_at', 'desc')->get();
    }

    public function render()
    {
        $this->getGames();
        return view('livewire.my-games',[
                        'gamesMe' => $this->gamesMe,
                        'gamesOp' => $this->gamesOp,
                        'gamesCh' => $this->gamesCh,
        ]);
    }
}
