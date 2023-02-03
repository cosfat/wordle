<?php

namespace App\Http\Livewire;

use App\Events\GuessTyped;
use App\Models\Challenge;
use App\Models\Chguess;
use App\Models\Chuser;
use App\Models\Game;
use App\Models\Guess;
use App\Models\Word;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class GuessRecorder extends Component
{
    protected $listeners = ['addGuess', 'addChGuess'];

    public function addGuess($word, $gameId)
    {
        $wordId = Word::whereName($word)->first()->id;
        $guess = new Guess();
        $guess->word_id = $wordId;
        $guess->game_id = $gameId;
        $guess->save();

        $game = Game::find($gameId);
        $game->seen2 = 0;
        $game->guesscount += 1;
        $game->save();
        GuessTyped::dispatch($game->user_id, $gameId, Auth::user()->username, 1);
    }

    public function addChGuess($word, $gameId)
    {
        if (Chuser::where('user_id', Auth::id())->where('challenge_id', $gameId)->exists()) {
            $challenge = Challenge::whereId($gameId)->where('winner_id', null);
            if ($challenge->exists()) {
                $wordId = Word::whereName($word)->first()->id;
                $guess = new Chguess();
                $guess->word_id = $wordId;
                $guess->challenge_id = $gameId;
                $user = Auth::user();
                $guess->user_id = $user->id;
                $guess->save();
                $c = $challenge->first();
                if($c == null){
                    $c = Challenge::find($gameId);
                }
                $c->guesscount = $c->guesscount + 1;
                $c->save();
                foreach ($c->chusers as $chuser) {
                    if($chuser->user_id != Auth::id()){
                        GuessTyped::dispatch($chuser->user_id, $c->id, $user->username, 2);
                    }
                }
            } else {
                return redirect('/finished-challenge-game-watcher/' . $gameId);
            }
        } else {
            session()->flash('message', 'Bu oyunu görme yetkiniz yok.');
            return redirect()->to('/create-game');
        }
    }


    public function render()
    {
        return view('livewire.guess-recorder');
    }
}
