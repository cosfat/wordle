<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Welcome extends Component
{
    public function mount()
    {
        if(Auth::check())
        {
            return redirect()->to('/create-game');
        }
        else{
            return view('livewire.welcome');
        }

    }
    public function render()
    {
        return view('livewire.welcome');
    }
}
