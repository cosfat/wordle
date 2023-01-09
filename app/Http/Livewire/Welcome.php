<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Welcome extends Component
{
    protected $listeners = ['showTheGame'];
    public $showCreate = true;
    public $showMyGames = false;
    public $showTheGame = false;
    public $showMyProfile = false;
    public $createColor =true;
    public $myGamesColor =false;
    public $myProfileColor =false;
    public $unseen;

    public function showCreate(){

        $this->showCreate = true;
        $this->showMyGames = false;
        $this->showMyProfile = false;
        $this->showTheGame = false;

        $this->createColor =true;
        $this->myGamesColor =false;
        $this->myProfileColor =false;
    }
    public function showMyGames(){
        $this->showCreate = false;
        $this->showMyGames = true;
        $this->showMyProfile = false;
        $this->showTheGame = false;

        $this->createColor =false;
        $this->myGamesColor =true;
        $this->myProfileColor =false;
    }
    public function showTheGame($gameId){
        $this->showCreate = false;
        $this->showMyGames = false;
        $this->showMyProfile = false;
        $this->showTheGame = true;
        $this->gameId = $gameId;

        $this->createColor =false;
        $this->myGamesColor =true;
        $this->myProfileColor =false;

        $this->emit('TheGame', $gameId);
    }

    public function showMyProfile(){
        $this->showCreate = false;
        $this->showMyGames = false;
        $this->showMyProfile = true;
        $this->showTheGame = false;

        $this->createColor =false;
        $this->myGamesColor =false;
        $this->myProfileColor =true;
    }

    public function unseen(){
        $this->unseen = false;
        $user = Auth::user();
        if($user->unseen()){
            $this->unseen = true;
        }
    }

    public function render()
    {
        if(Auth::user()){
            $this->unseen();
        }
        return view('livewire.welcome');
    }
}
