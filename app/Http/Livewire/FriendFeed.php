<?php

namespace App\Http\Livewire;

use App\Models\Game;
use App\Models\Point;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FriendFeed extends Component
{
    protected $friends;

    public function mount(){
       $this->friends = Point::orderBy('point', 'desc');
    }

    public function render()
    {

        return view('livewire.friend-feed', [
            'friends' => $this->friends->simplePaginate(10)
        ]);
    }
}
