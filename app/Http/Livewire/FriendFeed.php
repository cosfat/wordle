<?php

namespace App\Http\Livewire;

use App\Models\Game;
use App\Models\Point;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FriendFeed extends Component
{
    protected $all;
    protected $friends = array();
    protected $listeners = ['refreshFeed' => '$refresh'];

    public function render()
    {
        $usersMyAll = array();
        $gamesMe = Auth::user()->games();
        $gamesMyAll = Auth::user()->opponentGames()->union($gamesMe)->get();

        foreach ($gamesMyAll as $item) {
            $usersMyAll[$item->user_id] = $item->user();
            $usersMyAll[$item->opponent_id] = User::whereId($item->opponent_id)->first();
        }


        $this->all = Point::orderBy('point', 'desc');

        foreach ($this->all->get() as $point) {
            if(isset($usersMyAll[$point->user_id]))
            {
                $this->friends[] = $point;
            }
        }

        return view('livewire.friend-feed', [
            'all' => $this->all->limit(20)->get(),
            'friends' => $this->friends
        ]);
    }
}
