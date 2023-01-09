<?php

namespace App\Http\Livewire;

use App\Models\Game;
use App\Models\Guess;
use App\Models\User;
use App\Models\Word;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TheGame extends Component
{
    public $length;
    public $gameId;
    public $word;
    public $opponentName;

    public $guessesCount;
    public $guessesArray;

    public function mount($gameId)
    {
        $game = Game::whereId($gameId)->where('opponent_id', Auth::id());
        if ($game->exists()) {
            $game = $game->first();
            $guesses = $game->guesses()->get();
            foreach ($guesses as $guess) {
                $this->guessesArray[] = $guess->word->name;
            }
            $this->guessesCount = $guesses->count();

            $this->gameId = $gameId;
            $this->length = $game->length;
            $this->opponentName = User::find($game->user_id)->name;
        } else {
            session()->flash('message', 'Bu oyunu görme yetkiniz yok.');
            return redirect()->to('/create-game');
        }

    }

    public function render()
    {
        $game = Game::find($this->gameId);
        $game->seen = 1;
        $game->save();
        return view('livewire.the-game');
    }
}
