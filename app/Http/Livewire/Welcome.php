<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Welcome extends Component
{
    public $showCreate = true;
    public $showMyGames = false;
    public $showMyProfile = false;

    public function render()
    {
        return view('livewire.welcome');
    }
}
