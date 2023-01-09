<?php

namespace App\Http\Livewire;

use App\Models\Game;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class GameWatcher extends Component
{
    public $length;
    public $gameId;
    public $word;
    public $wordName;
    public $opponentName;

    public function mount($gameId)
    {
        $game = Game::whereId($gameId)->where('user_id', Auth::id());
        if ($game->exists()) {
            $game = $game->first();
            $this->length = $game->length;
            $this->gameId = $gameId;
            $this->wordName = $game->word->name;
            $this->opponentName = User::find($game->opponent_id)->name;
        } else {
            session()->flash('message', 'Bu oyunu görme yetkiniz yok.');
            return redirect()->to('/create-game');
        }

    }

    public function editGame($gameId, $word, $wordNumber)
    {
        $theWord = "word_" . $wordNumber;
        $game = Game::find($gameId);
        $game->$theWord = $word;
        $game->save();
    }

    public function render()
    {
        return view('livewire.game-watcher');
    }
}
