<?php

namespace App\Http\Livewire;

use App\Models\Game;
use App\Models\Point;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LeaderBoard extends Component
{
    protected $all;
    protected $friends;
    protected $listeners = ['refreshFeed' => '$refresh'];

    public function render()
    {
        $user = Auth::user();
        $this->friends = $user->contacts()->select(['points.*'])
            ->join('points', 'contacts.contact_id', '=', 'points.user_id')
            ->orderBy('points.point', 'desc')->get();

        $this->all = Point::orderBy('point', 'desc')->where('user_id', '!=', 2)->limit(20);


        return view('livewire.leader-board', [
            'all' => $this->all->limit(20)->get(),
            'friends' => $this->friends
        ]);
    }
}
