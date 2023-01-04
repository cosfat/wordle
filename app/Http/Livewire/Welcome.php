<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Welcome extends Component
{
    public $createGame = false;

    public function createGame(){
        $this->createGame = true;
    }
    public function render()
    {
        return view('livewire.welcome');
    }
}
