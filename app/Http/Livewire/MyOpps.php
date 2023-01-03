<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Game;

class MyOpps extends Component
{
    public $myOpps;

    public function mount(){
        $this->myOpps = Game::where('opponent_id', Auth::id())->get();
    }

    public function render()
    {
        return view('livewire.my-opps');
    }
}
