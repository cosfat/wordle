<?php

namespace App\Http\Livewire;

use App\Events\GameNotification;
use App\Models\User;
use App\Models\Word;
use App\Models\Game;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;

class CreateGame extends Component
{
    public $gameName;
    public $word;
    public $opponent;
    public $opponentId;
    public $opponentEmail;

    public $hideOpponent = true;
    public $wordError = false;
    public $opponentError = false;
    public $startGame = false;

    public $gameWord;
    public $gameOpp;

    public $gameId;

    public $letterLength = 5;

    public function test()
    {
        return false;
    }

    public function checkWord()
    {
        $word = $this->word;
        if (Word::where('name', $word)->exists() AND Str::length($word) == $this->letterLength) {
            $wordRow = Word::where('name', $word)->first();
            $this->wordError = false;
            $this->hideOpponent = false;
            $this->gameWord = $wordRow->id;
        } else {
            $this->wordError = true;
            $this->hideOpponent = true;
        }

    }

    public function autoWord()
    {

        $word = DB::select(DB::raw("SELECT id, name, CHAR_LENGTH(name) AS 'chrlen' FROM words WHERE CHAR_LENGTH(name) = $this->letterLength ORDER BY RAND() LIMIT 1"));
        $this->word = $word[0]->name;
        $this->wordError = false;
        $this->hideOpponent = false;
        $this->gameWord = $word[0]->id;

    }

    public function autoOpp()
    {
        if ($this->word == null or $this->wordError == true) {
            $this->hideOpponent = true;

        } else {
            $this->hideOpponent = false;
        }
        $opponent = User::where('id', '!=', Auth::id())->inRandomOrder()->first();
        $this->opponent = $opponent->name;
        $this->opponentId = $opponent->id;
        $this->startGame = true;
        $this->gameOpp = $opponent->id;
        $this->startGame();
    }

    public function checkEmail()
    {
        $email = $this->opponentEmail;
        $user = User::where('email', $email)->where('id', '!=', Auth::id());

        if ($user->exists()) {
            $this->opponent = $user->first()->name;
            $this->opponentId = $user->first()->id;
            $this->gameOpp = $this->opponentId;

            $this->opponentError = false;
            $this->startGame = true;
            $this->startGame();

        } else {
            $this->opponentError = true;
            $this->startGame = false;
        }
    }


    public function startGame()
    {
        $word = $this->gameWord;
        $opp = $this->gameOpp;

        $game = new Game;
        $game->user_id = Auth::id();
        $game->opponent_id = $opp;
        $game->word_id = $word;
        $game->save();
        $this->emit('MyGames');
        $this->gameId = $game->id;
        $this->gameName = $game->word->name;

        GameNotification::dispatch($opp);
    }

    public function render()
    {
        return view('livewire.create-game');
    }
}
