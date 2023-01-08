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

    public $showGame = false;

    public function getGames(){
        $this->games = Game::where('user_id', Auth::id())->orWhere('opponent_id', Auth::id())->orderBy('id', 'desc');
    }

    public function theGame($gameId){
        $this->showGame = true;
        $this->gameId = $gameId;
        $this->emit('TheGame');
    }

    public function render()
    {

        $this->games = Game::where('user_id', Auth::id())->orWhere('opponent_id', Auth::id())->orderBy('id', 'desc');
        return view('livewire.my-games',[
                        'games' => $this->games->simplePaginate(5),
        ]);
    }
}
