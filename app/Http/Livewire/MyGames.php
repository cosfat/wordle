<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MyGames extends Component
{
    protected $listeners = ['MyGames' => 'getGames'];
    public $games;

    public function mount(){
        $this->games = Auth::user()->games()->get();

    }

    public function getGames(){
        $this->games = Auth::user()->games()->get();
    }

    public function render()
    {
        return view('livewire.my-games');
    }
}
