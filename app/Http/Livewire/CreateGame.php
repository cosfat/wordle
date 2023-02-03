<?php

namespace App\Http\Livewire;

use App\Events\GameNotification;
use App\Events\GuessTyped;
use App\Models\Challenge;
use App\Models\Chuser;
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
    public $mode = 1;
    public $challengeUserName;

    public $hideOpponent = true;
    public $wordError = false;
    public $opponentError = false;
    public $chOpponentError = false;
    public $existingGameError = false;
    public $chExistingGameError = false;
    public $startGame = false;
    public $suggestBoxes = false;

    public $gameWord;
    public $gameOpp;

    public $length = 5;

    public $suggetNumber = 5;
    public $suggests = array();
    public $suggestFriend = array();
    public $suggestChFriend = array();
    public $challengeFriends = array();

    public function test()
    {
        return false;
    }

    public function addChallengeFriend($friend)
    {
        if (($key = array_search($friend, $this->challengeFriends)) !== false) {
            unset($this->challengeFriends[$key]);
        } else {
            if (count($this->challengeFriends) < 10) {
                $this->challengeFriends[] = $friend;
            }
        }
    }

    public function mount($length = 5)
    {
        $this->challengeFriends[] = Auth::user()->username;

        if ($length > 7) {
            $this->length = 6;
        } else {

            $this->length = $length;
        }

        $this->suggestChFriend();
    }

    public function suggestChFriend()
    {

        $gamesArray = array();
        $gamesMe = Game::where('user_id', Auth::id())->orderBy('id', 'desc')->limit(5)->get();
        $gamesOp = Game::where('opponent_id', Auth::id())->orderBy('id', 'desc')->limit(5)->get();
        foreach ($gamesMe as $game) {
            $gamesArray[] = User::whereId($game->opponent_id)->first()->name;
        }

        foreach ($gamesOp as $game) {
            $gamesArray[] = User::whereId($game->user_id)->first()->name;
        }
        $gamesArray = array_unique($gamesArray);

        if (count($gamesArray) < 1) {
            $users = User::where('id', '!=', Auth::id())->inRandomOrder()->limit(5)->pluck('username');
            foreach ($users as $user) {
                $gamesArray[] = $user;
            }
        }

        $gamesArray = array_unique($gamesArray);
        $this->suggestChFriend = $gamesArray;

        $this->suggestChFriend = array_unique($this->suggestChFriend);
    }

    public function suggestFriend()
    {
        $gamesArray = array();

        $games = Game::where('user_id', Auth::id())->orWhere('opponent_id', Auth::id())->where('winner_id', '!=', null)->orderBy('id', 'desc')->limit(10)->get();
        foreach ($games as $game) {
            if ($game->opponent_id == Auth::id()) {
                $user = User::whereId($game->user_id)->first();
                if (Game::where('user_id', Auth::id())->where('opponent_id', $user->id)->where('winner_id', null)->doesntExist()) {
                    $gamesArray[] = User::whereId($game->user_id)->first()->name;
                }
            } else {
                $user = User::whereId($game->opponent_id)->first();
                if (Game::where('user_id', Auth::id())->where('opponent_id', $user->id)->where('winner_id', null)->doesntExist()) {
                    $gamesArray[] = User::whereId($game->opponent_id)->first()->name;
                }
            }
        }


        if (count($gamesArray) < 1) {
            $users = User::where('id', '!=', Auth::id())->inRandomOrder()->limit(5)->pluck('username');

            foreach ($users as $user) {
                $gamesArray[] = $user;
            }
        }
        $gamesArray = array_unique($gamesArray);

        $this->suggestFriend = $gamesArray;
    }

    public function changeLength($length)
    {
        $this->length = $length;
        $this->word = "";
        $this->opponentUserName = null;
        $this->hideOpponent = true;
        $this->autoWord();
    }

    public function checkWord()
    {
        $word = $this->word;

        if (Word::where('name', $word)->exists() and Str::length($word) == $this->length and Word::tdk($word)) {
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
        if ($word->exists()) {
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
            if (Word::tdk($item->name)) {
                $this->suggests[] = $item->name;
            }
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


    public function autoChOpp()
    {
        $opponent = User::where('id', '!=', Auth::id())->inRandomOrder()->first()->name;

        $this->suggestChFriend[] = $opponent;
        $this->suggestChFriend = array_unique($this->suggestChFriend);
        $this->addChallengeFriend($opponent);

    }

    public function checkChallengeUsername()
    {
        $username = $this->challengeUserName;

        if (array_search($username, $this->challengeFriends)) {
            return false;
        } else {
            $user = User::where('username', $username)->where('id', '!=', Auth::id());


            if ($user->exists()) {

                $this->chOpponentError = false;
                $this->chExistingGameError = false;
                $this->suggestChFriend[] = $user->first()->name;
                $this->suggestChFriend = array_unique($this->suggestChFriend);
                $this->addChallengeFriend($user->first()->name);


            } else {
                $this->chOpponentError = true;
                $this->chExistingGameError = false;
            }
        }

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
                if ($guessCount < 6) {
                    $existing = true;
                    break;
                }
            }

            if ($existing == false) {
                $this->opponent = $user->first()->name;
                $this->opponentId = $user->first()->id;
                $this->gameOpp = $this->opponentId;

                $this->opponentError = false;
                $this->existingGameError = false;
                $this->startGame = true;
                $this->startGame();
            } else {
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
        return redirect()->to('/game-watcher/' . $game->id);
    }


    public function startChallengeGame()
    {
        $suggestQuery = DB::select(DB::raw("SELECT id, name, CHAR_LENGTH(name) AS 'chrlen' FROM words WHERE CHAR_LENGTH(name) = $this->length ORDER BY RAND() LIMIT 20"));
        foreach ($suggestQuery as $item) {
            if (Word::tdk($item->name)) {
                $word = $item->name;
                $wordId = $item->id;
                break;
            }
        }

        $game = new Challenge;
        $game->user_id = Auth::id();
        $game->word_id = $wordId;
        $game->length = $this->length;
        $game->usercount = count($this->challengeFriends);
        $game->save();

        foreach ($this->challengeFriends as $challengeFriend) {
            $team = new Chuser;
            $team->challenge_id = $game->id;
            $team->user_id = User::where('username', $challengeFriend)->first()->id;
            $team->save();

            if ($team->user_id != Auth::id()) {
                GameNotification::dispatch($team->user_id);
            }
        }
        session()->flash('message', 'Oyun başarıyla oluşturuldu.');
        return redirect()->to('/the-challenge-game/' . $game->id);
    }

    public function render()
    {
        return view('livewire.create-game');
    }
}
