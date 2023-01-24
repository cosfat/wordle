<?php

namespace App\Http\Livewire;

use App\Models\Game;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class MyGames extends Component
{
    use WithPagination;
    public $gameId;

    protected $listeners = ['MyGames' => 'getGames'];
    protected $games;

    public function getGames(){
        $this->games = Game::where('opponent_id', Auth::id())->orWhere('user_id', Auth::id())->where('winner_id', null)->orderBy('updated_at', 'desc');
    }

    public function theGame($gameId){
        $this->emitUp('showTheGame', $gameId);
    }

    public function render()
    {

        $this->games = Game::where('user_id', Auth::id())->orWhere('opponent_id', Auth::id())->where('winner_id', null)->orderBy('updated_at', 'desc');
        return view('livewire.my-games',[
                        'games' => $this->games->simplePaginate(6),
        ]);
    }
}
