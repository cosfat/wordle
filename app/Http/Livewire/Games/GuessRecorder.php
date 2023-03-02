<?php

namespace App\Http\Livewire\Games;

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
    protected $listeners = ['addGuess', 'addChGuess', 'siraChange'];

    public $sira = null;

    public function addGuess($word, $gameId, $isDuello = 0)
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
        if($game->guesscount == 1){
            $this->emit('startCounterFirstTime');
            }
        if($isDuello == 0){
            GuessTyped::dispatch($game->user_id, $gameId, Auth::user()->username, 1, Auth::id(), 0, $word);
        }
        else{
            $this->siraChange($gameId);
            if($game->user_id == Auth::id()){
                GuessTyped::dispatch($game->opponent_id, $gameId, Auth::user()->username, 1, Auth::id(), 1, $word);
            }
            else{
                GuessTyped::dispatch($game->user_id, $gameId, Auth::user()->username, 1, Auth::id(), 1, $word);
            }
        }
    }

    public function addChGuess($word, $gameId)
    {
        if (Chuser::where('user_id', Auth::id())->where('challenge_id', $gameId)->exists()) {
            $challenge = Challenge::whereId($gameId)->whereNull('winner_id');
            if ($challenge->exists()) {
                $wordId = Word::whereName($word)->first()->id;
                $guess = new Chguess();
                $guess->word_id = $wordId;
                $guess->challenge_id = $gameId;
                $user = Auth::user();
                $guess->user_id = $user->id;
                $guess->save();
                if($user->chguesses()->where('challenge_id', $gameId)->count() == 1){
                    $this->emit('startCounterFirstTime');
                }
                $c = $challenge->first();
                if($c == null){
                    $c = Challenge::find($gameId);
                }
                $c->guesscount = $c->guesscount + 1;
                $c->save();
                foreach ($c->chusers as $chuser) {
                    if($chuser->user_id != Auth::id()){
                        GuessTyped::dispatch($chuser->user_id, $c->id, $user->username, 2, $user->id, 0, $word);
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


    public function siraChange($gameId, $withRefresh = 0)
    {
        $game = Game::find($gameId);
        if($game->sira == $game->user_id){
            $game->sira = $game->opponent_id;
        }
        else{
            $game->sira = $game->user_id;
        }

        $this->sira = $game->sira;
        $game->save();
        if($withRefresh != 0){
            GuessTyped::dispatch($this->sira, $gameId, 'Rakip', 6, 0, 1, 0);
        }
    }


    public function render()
    {
        return view('livewire.games.guess-recorder');
    }
}
