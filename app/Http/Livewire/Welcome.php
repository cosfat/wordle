<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Welcome extends Component
{
    public function mount()
    {
        if(Auth::check()){
            if(Auth::user()->games()->count() > 0)
            {
                return redirect()->to('/my-games');
            }
            else{
                return redirect()->to('/create-game');
            }
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
