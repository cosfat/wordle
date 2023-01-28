<?php

namespace App\Http\Livewire;

use App\Events\GameNotification;
use App\Events\GuessTyped;
use App\Models\Point;
use App\Models\User;
use App\Models\Word;
use App\Models\Game;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;

class CreateGame extends Component
{
    public $word;
    public $opponent;
    public $opponentId;
    public $opponentUserName;

    public $hideOpponent = true;
    public $wordError = false;
    public $opponentError = false;
    public $existingGameError = false;
    public $startGame = false;
    public $suggestBoxes = false;

    public $gameWord;
    public $gameOpp;

    public $length = 5;

    public $suggetNumber = 5;
    public $suggests = array();
    public $suggestFriend = array();

    public function test()
    {
        return false;
    }

    public function mount($length = 5){

        if($length > 7){
            $this->length = 6;
        }
        else {

            $this->length = $length;
        }
    }

    public function suggestFriend()
    {
        $gamesArray = array();
        $games = Game::where('user_id', Auth::id())->orWhere('opponent_id', Auth::id())->get();
        foreach ($games as $game) {
            if($game->opponent_id == Auth::id()){
                $user = User::whereId($game->user_id)->first();
                if(Game::where('user_id', Auth::id())->where('opponent_id', $user->id)->where('winner_id', null)->doesntExist()){
                    $gamesArray[] = User::whereId($game->user_id)->first()->name;
                }
            }
            else{
                $user = User::whereId($game->opponent_id)->first();
                if(Game::where('user_id', Auth::id())->where('opponent_id', $user->id)->where('winner_id', null)->doesntExist()){
                    $gamesArray[] = User::whereId($game->opponent_id)->first()->name;
                }
            }
        }

        if(count($gamesArray) < 1){
           $users = User::where('id', '!=', Auth::id())->inRandomOrder()->limit(5)->pluck('username');

            foreach ($users as $user) {
                $gamesArray[] = $user;
           }
        }
        $gamesArray = array_unique($gamesArray);

        $this->suggestFriend = $gamesArray;
    }

    public function changeLength($length){
        $this->length = $length;
    }

    public function checkWord()
    {
        $word = $this->word;

        if (Word::where('name', $word)->exists() AND Str::length($word) == $this->length) {
            $wordRow = Word::where('name', $word)->first();
            $this->wordError = false;
            $this->hideOpponent = false;
            $this->suggestFriend();
            $this->gameWord = $wordRow->id;
        } else {
            $this->wordError = true;
            $this->hideOpponent = true;
        }

    }

    public function pickSuggest($s)
    {
        $word = Word::whereName($s);
        if($word->exists()){
            $this->word = $word->first()->name;
            $this->gameWord = $word->first()->id;
            $this->wordError = false;
            $this->hideOpponent = false;
            $this->suggestFriend();
        }
    }

    public function autoWord()
    {
        $this->suggests = [];

        $suggestQuery = DB::select(DB::raw("SELECT id, name, CHAR_LENGTH(name) AS 'chrlen' FROM words WHERE CHAR_LENGTH(name) = $this->length ORDER BY RAND() LIMIT $this->suggetNumber"));

        foreach ($suggestQuery as $item) {
            $this->suggests[] = $item->name;
        }
        $this->suggestBoxes = true;

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
        $username = $this->opponentUserName;
        $user = User::where('username', $username)->where('id', '!=', Auth::id());

        $existing = false;

        if ($user->exists()) {
            $existingGames = Game::where('user_id', Auth::id())->where('opponent_id', $user->first()->id)->where('winner_id', null)->get();
            foreach ($existingGames as $existingGame) {
                $guessCount = $existingGame->guesses()->count();
                if($guessCount < 6){
                    $existing = true;
                    break;
                }
            }

            if($existing == false){
                $this->opponent = $user->first()->name;
                $this->opponentId = $user->first()->id;
                $this->gameOpp = $this->opponentId;

                $this->opponentError = false;
                $this->existingGameError = false;
                $this->startGame = true;
                $this->startGame();
            }
            else{
                $this->opponentError = true;
                $this->existingGameError = true;
                $this->startGame = false;
            }

        } else {
            $this->opponentError = true;
            $this->existingGameError = false;
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
        $game->length = $this->length;
        $game->save();
        GameNotification::dispatch($opp);
        session()->flash('message', 'Oyun başarıyla oluşturuldu.');
        return redirect()->to('/game-watcher/'.$game->id);
    }

    public function render()
    {
        return view('livewire.create-game');
    }
}
