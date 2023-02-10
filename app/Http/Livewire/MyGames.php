<?php

namespace App\Http\Livewire;

use App\Models\Challenge;
use App\Models\Chguess;
use App\Models\Chuser;
use App\Models\Game;
use App\Models\Guess;
use App\Models\Today;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MyGames extends Component
{
    public $gameId;
    public $today = 0;
    public $todayGame;
    public $shortName = null;
    public $fastName = null;
    public $shortValue = null;
    public $fastValue = null;

    protected $listeners = ['MyGames' => '$refresh'];

    protected $games;
    protected $new;

    protected $gamesMe;
    protected $gamesOpp;

    protected $newChallenges;
    protected $activeChallenges;

    protected $user;

    public function mount(){
        $todayId = Today::orderBy('id', 'desc')->first()->id;
        $fastest = Game::where('today_id', $todayId)->where('winner_id', '!=', 2)->where('winner_id', '!=', null)->orderBy('duration', 'asc')->first();
        if($fastest != null){
            $this->fastName = $fastest->user()->username;
            $this->fastValue = $fastest->duration;
        }
        $shortest = Game::where('today_id', $todayId)->where('winner_id', '!=', 2)->where('winner_id', '!=', null)->orderBy('guesscount', 'asc')->orderBy('duration', 'asc')->first();
        if($shortest != null){
            $this->shortName = $shortest->user()->username;
            $this->shortValue = $shortest->guesscount;
        }


        $game = Auth::user()->opponentGames()->where('today_id', $todayId)->first();
        if($game->seen == 0){
            $this->today = 0;
        }
        elseif ($game->winner_id == Auth::id()){
            $this->today = 2;
        }
        elseif ($game->winner_id == 2){
            $this->today = 3;
        }
        else{
            $this->today = 1;
        }

        $this->todayGame = $game;
    }


    public function new()
    {
        return Auth::user()->opponentGames()->where('seen', 0)->where('user_id', '!=', 2)->orderBy('id', 'desc')->get();
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
            ->whereNull('winner_id')
            ->orderBy('guesses.created_at', 'desc')->get();

        $this->gamesMe = $gamesMe->groupBy('id');


        $gamesOpp = Auth::user()->opponentGames()->where('user_id', '!=', 2)->select(['games.*'])
            ->leftJoin('guesses', 'games.id', '=', 'guesses.game_id')
            ->whereNull('winner_id')
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
