<?php

namespace App\Http\Livewire\Games;

use App\Events\GameNotification;
use App\Events\GuessTyped;
use App\Models\Challenge;
use App\Models\Chguess;
use App\Models\Chuser;
use App\Models\Point;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Http\Request;

class TheChallengeGame extends Component
{
    public $length;
    public $gameId;
    public $word;
    public $opponents = array();

    public $guessesCount;
    public $guessesArray;
    public $start;
    public $firstGuess = false;
    public $replay = 0;
    public $owner;
    public $game;
    public $multichat;
    public $frequents = array();

    protected $listeners = ['chWinner', 'chLoser'];


    public function chWinner()
    {
        $userId = Auth::id();
        $game = Challenge::whereId($this->gameId)->first();


        if (Chuser::where('user_id', Auth::id())->where('challenge_id', $this->gameId)->exists()) {
            if (Challenge::whereId($this->gameId)->whereNull('winner_id')->exists()) {
                $users = $game->chusers()->get();
                foreach ($users as $user) {
                    $guesscount = Chguess::where('challenge_id', $game->id)->where('user_id', $user->user_id)->count();
                    if ($guesscount == 0) {
                        $user->delete();
                    }
                }
                $userCount = $game->chusers()->count();
                $game->winner_id = $userId;

                if (Chguess::where('user_id', $game->winner_id)->where('challenge_id', $game->id)->count() == 1) {
                    $game->duration = $game->created_at->diffInSeconds(Chguess::where('user_id', $game->winner_id)->where('challenge_id', $game->id)->first()->created_at);
                } else {
                    $first = Chguess::where('user_id', $game->winner_id)->where('challenge_id', $game->id)->orderBy('created_at', 'asc')->first()->created_at;
                    $last = Chguess::where('user_id', $game->winner_id)->where('challenge_id', $game->id)->orderBy('created_at', 'desc')->first()->created_at;
                    $game->duration = $first->diffInSeconds($last);
                }
                $durationPoint = round(500 / $game->duration);
                $game->point = ($game->length - Chguess::whereChallenge_id($this->gameId)->where('user_id', $userId)->count() + 10) * $userCount * 2 + $durationPoint;
                $game->save();

                $point = Point::whereUser_id($userId);
                if ($point->exists()) {
                    $point = $point->first();
                    $point->point = $point->point + $game->point + $durationPoint;
                    $point->save();
                } else {
                    $point = new Point;
                    $point->user_id = $userId;
                    $point->point = $game->point + $durationPoint;
                    $point->save();
                }
                if($game->replay == 0){
                    foreach ($game->chusers as $chuser) {
                        if ($chuser->user_id != Auth::id()) {
                            GuessTyped::dispatch($chuser->user_id, $game->id, Auth::user()->username, 4, Auth::id(), 0, 0);
                        }
                    }
                    return redirect('/finished-challenge-game-watcher/' . $this->gameId);
                }

                if ($game->replay == 1) {
                    $g = new Challenge();
                    if ($game->chusers->count() == 1) {
                        $g->user_id = Auth::id();
                    } else {
                        $g->user_id = $game->user_id;
                    }
                    $g->length = $game->length;
                    $g->replay = $game->replay;
                    $g->usercount = $game->usercount;
                    $g->multichat = $game->multichat;
                    $suggestQuery = DB::select(DB::raw("SELECT id, meaning, name, CHAR_LENGTH(name) AS 'chrlen' FROM words WHERE CHAR_LENGTH(name) = $game->length AND meaning != 'null' ORDER BY RAND() LIMIT 1"));
                    foreach ($suggestQuery as $item) {
                        $g->word_id = $item->id;
                    }
                    $g->save();
                    $previous = $game->id;
                    foreach ($game->chusers as $chuser) {
                        $team = new Chuser;
                        $team->challenge_id = $g->id;
                        $team->user_id = $chuser->user_id;
                        $team->save();

                        GameNotification::dispatch($team->user_id, $g->id, User::find($userId)->username, 23, $previous, $game->word->name);
                    }
                    session()->flash('message', 'Oyun otomatik başlatıldı');
                    return redirect('/the-challenge-game/' . $g->id);
                }
            } else {
                return redirect('/finished-challenge-game-watcher/' . $this->gameId);
            }
        } else {
            session()->flash('message', 'Bu oyunu görme yetkiniz yok.');
            return redirect()->to('/create-game');
        }

    }

    public function chLoser()
    {

        return redirect('/finished-challenge-game-watcher/' . $this->gameId);
    }


    public function mount($gameId)
    {
        if (Chuser::where('user_id', Auth::id())->where('challenge_id', $gameId)->exists()) {
            if (Challenge::whereId($gameId)->whereNull('winner_id')->exists()) {

                $game = Challenge::whereId($gameId)->first();
                $this->multichat = $game->multichat;
                $this->game = $game;
                if($game->replay == 1 AND $game->multichat != $game->id AND $game->chusers->count() > 1){
                    $this->waitForOthers = true;
                }
                if (Chguess::where('challenge_id', $gameId)->where('user_id', Auth::id())->count() == $game->length + 1) {
                    return redirect('/finished-challenge-game-watcher/' . $this->gameId);
                } else {
                    $guesses = Chguess::where('challenge_id', $game->id)->where('user_id', Auth::id())->get();
                    foreach ($guesses as $guess) {
                        $this->guessesArray[] = $guess->word->name;
                    }

                    $this->guessesCount = $guesses->count();
                    if ($guesses->count() == 0) {
                        $this->firstGuess = true;
                    }

                    $this->gameId = $gameId;
                    $this->length = $game->length;
                    $this->frequents = $this->frequentWords();
                    foreach ($game->chusers as $chuser) {
                        $this->opponents[$chuser->user_id] = User::whereId($chuser->user_id)->first()->name;
                    }

                    $this->replay = $game->replay;
                    $this->owner = $game->user_id;

                }
            } else {
                return redirect('/finished-challenge-game-watcher/' . $this->gameId);
            }

        } else {
            session()->flash('message', 'Bu oyunu görme yetkiniz yok.');
            return redirect()->to('/create-game');
        }

    }

    public function replayState()
    {
        if ($this->replay == 0) {
            $this->replay = 1;
        } else {
            $this->replay = 0;
        }
        $game = $this->game;
        $game->replay = $this->replay;
        $game->save();

        return redirect('/the-challenge-game/' . $this->gameId);
    }

    public function frequentWords(){
        $guessesX = array();
        $games = Auth::user()->opponentGames()->where('length', $this->length)->orderBy('id', 'desc')->limit(10)->get();
        $chGames = Challenge::where('user_id', Auth::id())->where('length', $this->length)->orderBy('id', 'desc')->limit(10)->get();
        foreach ($games as $game) {
            if($game->guesses()->first() != null){
                $guessesX[] = $game->guesses()->first()->word->name;
            }
        }

        foreach ($chGames as $chGame) {
            $guess = $chGame->chguesses()->where('user_id', Auth::id())->first();
            if($guess != null)
            {
                $guessesX[] = $guess->word->name;
            }
        }

        $values = array_count_values($guessesX);
        arsort($values);
        return array_slice(array_keys($values), 0, 5, true);

    }

    public function render()
    {
        $chuser = Chuser::where('challenge_id', $this->gameId)->where('user_id', Auth::id())->first();
        $chuser->seen = 1;
        $chuser->save();
        $first = Auth::user()->chguesses()->where('challenge_id', $this->gameId)->first();
        if ($first != null) {
            $this->start = $first->created_at->diffInSeconds(Carbon::now());
        } else {
            $this->start = 0;
        }
        return view('livewire.games.the-challenge-game');
    }
}
