<?php

namespace App\Http\Livewire;

use App\Events\GameNotification;
use App\Events\GuessTyped;
use App\Models\Challenge;
use App\Models\Chuser;
use App\Models\Point;
use App\Models\Today;
use App\Models\User;
use App\Models\Word;
use App\Models\Game;
use Carbon\Carbon;
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

    public $replay = 0;
    public $replayText = "Otomatik başlatma kapalı";

    public function test()
    {
        return false;
    }

    public function mount($length = 5)
    {
        $this->challengeFriends[] = Auth::user()->username;

        if ($length > 7) {
            $this->length = 6;
        } else {
            $this->length = $length;
        }
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


    public function makeMode2()
    {
        $this->mode = 2;
        $this->suggestChFriend();
    }

    public function makeMode4()
    {
        $this->mode = 4;
        $this->suggestFriend();
        $this->hideOpponent = false;
    }

    public function suggestChFriend()
    {
        $gamesArray = array();
        $contacts = Auth::user()->contacts()->get();
        $chGames = Chuser::where('user_id', Auth::id())->orderBy('id', 'desc')->limit(5)->get();
        foreach ($chGames as $chGame) {
            $chid = $chGame->challenge_id;
            $chusers = Chuser::where('user_id', '!=', Auth::id())->where('user_id', '!=', 2)->where('challenge_id', $chid)->pluck('user_id');
            foreach ($chusers as $chuser) {
                $gamesArray[] = User::find($chuser)->username;
            }
        }
        if (count($gamesArray) < 2) {
            foreach ($contacts as $contact) {
                $gamesArray[] = $contact->user->username;
            }
        }
        $gamesArray = array_unique($gamesArray);
        if (count($gamesArray) < 1) {
            $gamesMe = Game::where('user_id', Auth::id())->orderBy('id', 'desc')->limit(100)->get();
            $gamesOp = Game::where('opponent_id', Auth::id())->where('user_id', '!=', 2)->orderBy('id', 'desc')->limit(100)->get();
            foreach ($gamesMe as $game) {
                $gamesArray[] = User::whereId($game->opponent_id)->first()->name;
            }
            foreach ($gamesOp as $game) {
                $gamesArray[] = User::whereId($game->user_id)->first()->name;
            }
            $gamesArray = array_unique($gamesArray);
            if (count($gamesArray) < 1) {
                foreach ($contacts as $contact) {
                    $gamesArray[] = $contact->user->username;
                }
                if (count($gamesArray) < 1) {
                    $users = User::where('id', '!=', Auth::id())->inRandomOrder()->limit(5)->pluck('username');
                    foreach ($users as $user) {
                        $gamesArray[] = $user;
                    }
                }
                $gamesArray = array_unique($gamesArray);
            }
        }
        $this->suggestChFriend = $gamesArray;
    }

    public function suggestFriend()
    {
        $gamesArray = array();
        $contacts = Auth::user()->contacts()->get();
        foreach ($contacts as $contact) {
            $gamesArray[] = $contact->user->username;
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
        $word = strtolower($this->word);

        if (Word::where('name', $word)->where('meaning', '!=', null)->exists() AND Str::length($word) == $this->length) {
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

        $suggestQuery = DB::select(DB::raw("SELECT id, meaning, name, CHAR_LENGTH(name) AS 'chrlen' FROM words WHERE CHAR_LENGTH(name) = $this->length AND meaning != 'null' ORDER BY RAND() LIMIT $this->suggetNumber"));

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
        $opponent = User::where('id', '!=', Auth::id())->where('id', '!=', 2)->inRandomOrder()->first();
        $this->opponent = $opponent->name;
        $this->opponentId = $opponent->id;
        $this->startGame = true;
        $this->gameOpp = $opponent->id;
        $this->startGame();
    }


    public function autoChOpp()
    {
        $opponent = User::where('id', '!=', Auth::id())->where('id', '!=', 2)->inRandomOrder()->first()->name;

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
                $this->challengeUserName = "";


            } else {
                $this->chOpponentError = true;
                $this->chExistingGameError = false;
            }
        }

    }

    public function checkEmail()
    {
        $username = $this->opponentUserName;
        $user = User::where('username', $username)->where('id', '!=', Auth::id())->where('id', '!=', 2);

        $existing = false;

        if ($user->exists()) {
            $existingGames = Game::where('user_id', Auth::id())->where('opponent_id', $user->first()->id)->whereNull('winner_id')->get();
            foreach ($existingGames as $existingGame) {
                $guessCount = $existingGame->guesses()->count();
                if ($guessCount < 5) {
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
        if ($this->mode == 3) {
            $word = $this->gameWord;
            $opp = $this->gameOpp;

            $game = new Game;
            $game->user_id = Auth::id();
            $game->opponent_id = $opp;
            $game->word_id = $word;
            $game->length = $this->length;
            $game->save();
            GameNotification::dispatch($opp, $game->id, Auth::user()->username, 1, null, null);
            session()->flash('message', 'Oyun başarıyla oluşturuldu.');
            return redirect()->to('/game-watcher/' . $game->id);
        } elseif ($this->mode == 4) {
            $opp = $this->gameOpp;
            $game = new Game;
            $game->user_id = Auth::id();
            $game->sira = $opp;
            $game->opponent_id = $opp;

            $suggestQuery = DB::select(DB::raw("SELECT id, meaning, name, CHAR_LENGTH(name) AS 'chrlen' FROM words WHERE CHAR_LENGTH(name) = $this->length  AND meaning != 'null' ORDER BY RAND() LIMIT 1"));
            foreach ($suggestQuery as $item) {
                    $word = $item->name;
                    $wordId = $item->id;
            }
            $game->word_id = $wordId;
            $game->isduello = 1;
            $game->length = $this->length;
            $game->save();
            GameNotification::dispatch($opp, $game->id, Auth::user()->username, 3, null, null);
            session()->flash('message', 'Oyun başarıyla oluşturuldu.');
            return redirect()->to('/the-game/' . $game->id . "/1");
        }
    }


    public function startChallengeGame()
    {
        $suggestQuery = DB::select(DB::raw("SELECT id, meaning, name, CHAR_LENGTH(name) AS 'chrlen' FROM words WHERE CHAR_LENGTH(name) = $this->length AND meaning != 'null' ORDER BY RAND() LIMIT 1"));
        foreach ($suggestQuery as $item) {
                $word = $item->name;
                $wordId = $item->id;
        }

        $game = new Challenge;
        $game->user_id = Auth::id();
        $game->word_id = $wordId;
        $game->length = $this->length;
        $game->replay = $this->replay;
        $game->usercount = count($this->challengeFriends);
        $game->save();
        $game->multichat = $game->id;
        $game->save();
        foreach ($this->challengeFriends as $challengeFriend) {
            $team = new Chuser;
            $team->challenge_id = $game->id;
            $user = User::where('username', $challengeFriend)->first();
            $team->user_id = $user->id;
            $team->save();

            if ($team->user_id != Auth::id()) {
                GameNotification::dispatch($team->user_id, $game->id, Auth::user()->username, 2, null, null);
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
