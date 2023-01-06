<?php

namespace App\Http\Livewire;

use Livewire\Component;

class TheGame extends Component
{
    public $gameWord;
    public $gameId;

    public function render()
    {
        return view('livewire.the-game');
    }
}
