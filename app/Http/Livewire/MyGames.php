<?php

namespace App\Http\Livewire;

use App\Models\Challenge;
use App\Models\Chguess;
use App\Models\Chuser;
use App\Models\Game;
use App\Models\Guess;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MyGames extends Component
{
    public $gameId;

    protected $listeners = ['MyGames' => '$refresh'];

    protected $games;
    protected $new;

    protected $gamesMe;
    protected $gamesOpp;

    protected $newChallenges;
    protected $activeChallenges;

    protected $user;


    public function new()
    {
        return Auth::user()->opponentGames()->where('seen', 0)->orderBy('id', 'desc')->get();
    }

    public function newChallenges()
    {
        return Auth::user()->challenges()->select(['chusers.*'])
            ->join('challenges', 'challenges.id', '=', 'chusers.challenge_id')
            ->where('challenges.winner_id', '=', null)
            ->where('seen', 0)->orderBy('id', 'desc')->get();
    }

    public function activeChallenges()
    {
        $games = Auth::user()->challenges()->select(['chusers.*'])
            ->join('challenges', 'challenges.id', '=', 'chusers.challenge_id')
            ->where('challenges.winner_id', '=', null)
            ->orderBy('challenges.id', 'desc')->get();

        $gamesArray = array();


        foreach ($games as $game) {
            $guesses = $game->challenge->guesscount;
            $userCount = $game->challenge->usercount;
            $length = $game->challenge->length + 1;
            $totalHak = $length * $userCount;
            if ($guesses < $totalHak) {
                $gamesArray[] = $game;
            }
        }


        return $gamesArray;
    }

    public function truncate()
    {

        Challenge::truncate();
        Chuser::truncate();
        Chguess::truncate();
        Game::truncate();
        Guess::truncate();
    }

    public function render()
    {
        $gamesMe = Auth::user()->games()->select(['games.*'])
            ->leftJoin('guesses', 'games.id', '=', 'guesses.game_id')
            ->where('winner_id', null)
            ->orderBy('guesses.created_at', 'desc')->get();

        $this->gamesMe = $gamesMe->groupBy('id');


        $gamesOpp = Auth::user()->opponentGames()->select(['games.*'])
            ->leftJoin('guesses', 'games.id', '=', 'guesses.game_id')
            ->where('winner_id', null)
            ->orderBy('guesses.created_at', 'desc')->get();

        $this->gamesOpp = $gamesOpp->groupBy('id');
        return view('livewire.my-games', [
            'user' => Auth::user(),
            'gamesMe' => $this->gamesMe,
            'gamesOpp' => $this->gamesOpp,
            'new' => $this->new(),
            'newChallenges' => $this->newChallenges(),
            'activeChallenges' => $this->activeChallenges()
        ]);
    }
}
