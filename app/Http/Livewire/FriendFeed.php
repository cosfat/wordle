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
    protected $listeners = ['refreshFeed' => '$refresh'];

    public function render()
    {
        $this->friends = Point::orderBy('point', 'desc');

        return view('livewire.friend-feed', [
            'friends' => $this->friends->limit(20)->get()
        ]);
    }
}
