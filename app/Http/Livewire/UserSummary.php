<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class UserSummary extends Component
{
    protected $games;
    protected $user;
    public function mount($user)
    {
        $this->user = User::findOrFail($user);
        $this->games = $this->user->opponentGames;

    }

    public function render()
    {
        return view('livewire.user-summary', [
            'games' => $this->games,
            'user' => $this->user
        ]);
    }
}
