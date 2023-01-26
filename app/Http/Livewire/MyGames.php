<?php

namespace App\Http\Livewire;

use App\Models\Game;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class MyGames extends Component
{
    use WithPagination;
    public $gameId;

    protected $listeners = ['MyGames' => 'getGames'];
    protected $gamesMe;
    protected $gamesOp;
    protected $gamesFin;

    public function getGames(){
        $this->gamesMe = Game::where('user_id', Auth::id())->where('winner_id', null)->orderBy('updated_at', 'desc')->get();
        $this->gamesOp = Game::where('opponent_id', Auth::id())->where('winner_id', null)->orderBy('updated_at', 'desc')->get();
    }

    public function theGame($gameId){
        $this->emitUp('showTheGame', $gameId);
    }

    public function render()
    {
        $this->gamesMe = Game::where('user_id', Auth::id())->where('winner_id', null)->orderBy('updated_at', 'desc')->get();
        $this->gamesOp = Game::where('opponent_id', Auth::id())->where('winner_id', null)->orderBy('updated_at', 'desc')->get();
        return view('livewire.my-games',[
                        'gamesMe' => $this->gamesMe,
                        'gamesOp' => $this->gamesOp,
        ]);
    }
}
