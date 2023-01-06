<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Welcome extends Component
{
    public $showCreate = true;
    public $showMyGames = false;
    public $showMyProfile = false;
    public $createColor =true;
    public $myGamesColor =false;
    public $myProfileColor =false;

    public function showCreate(){

        $this->showCreate = true;
        $this->showMyGames = false;
        $this->showMyProfile = false;

        $this->createColor =true;
        $this->myGamesColor =false;
        $this->myProfileColor =false;
    }
    public function showMyGames(){
        $this->showCreate = false;
        $this->showMyGames = true;
        $this->showMyProfile = false;

        $this->createColor =false;
        $this->myGamesColor =true;
        $this->myProfileColor =false;
    }
    public function showMyProfile(){
        $this->showCreate = false;
        $this->showMyGames = false;
        $this->showMyProfile = true;

        $this->createColor =false;
        $this->myGamesColor =false;
        $this->myProfileColor =true;
    }

    public function render()
    {
        return view('livewire.welcome');
    }
}
