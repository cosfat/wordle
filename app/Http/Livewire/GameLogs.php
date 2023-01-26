<?php

namespace App\Http\Livewire;

use App\Models\Game;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class GameLogs extends Component
{
    public $notes = array();

    public function render()
    {
        $finished = Game::where('user_id', Auth::id())->where('winner_id', '!=', null)->orderBy('updated_at', 'desc')->limit(10)->get();
        $x = 0;
        foreach ($finished as $game) {
            $guesses = $game->guesses();
            $username = User::whereId($game->opponent_id)->first()->username;
            $count = $guesses->count();
            $word = $game->word->name;

            $this->notes[$x]['user'] = $username;
            $this->notes[$x]['word'] = $word;

            if ($game->winner_id != Auth::id()) {
                $this->notes[$x]['status'] = 1;
                $this->notes[$x]['count'] = $count;
            } else {
                $this->notes[$x]['status'] = 0;
            }
            $x += 1;
        }
        return view('livewire.game-logs');
    }
}
