<?php

namespace App\Http\Livewire;

use App\Models\Challenge;
use App\Models\Chguess;
use App\Models\Chuser;
use App\Models\Game;
use App\Models\Guess;
use App\Models\Today;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MyGames extends Component
{
    public $gameId;
    public $today = 0;
    public $todays = array();
    public $todayGame;
    public $shortName = null;
    public $shortId = null;
    public $fastName = null;
    public $fastId = null;
    public $shortValue = null;
    public $fastValue = null;
    public $todayWinners;
    public $todayLosers;
    public $diff;
    protected $duellos;

    protected $listeners = ['MyGames' => '$refresh'];

    protected $games;
    protected $new;

    protected $gamesMe;
    protected $gamesOpp;

    protected $newChallenges;
    protected $activeChallenges;

    protected $user;

    public function mount(){
        $now = Carbon::now();
        $currentHour = $now->hour;
        $x = 1;
        while(true){
            if(($x + $currentHour)%6 == 0)
            {
                break;
            }
            $x += 1;
        }
        $nextDate = $now->addHours($x);
        $nextStart = Carbon::create($nextDate->year, $nextDate->month, $nextDate->day, $nextDate->hour, 0, 0);
        $this->diff = $nextStart->diffForHumans(Carbon::now());

        $today = Today::orderBy('id', 'desc')->first();
        if(Game::where('user_id', 2)->where('opponent_id', Auth::id())->where('today_id', $today->id)->doesntExist()){
            $game = new Game();
            $game->user_id = 2;
            $game->opponent_id = Auth::id();
            $game->word_id = $today->word_id;
            $game->today_id = $today->id;
            $game->length = Game::where('user_id', 2)->where('today_id', $today->id)->first()->length;
            $game->save();
        }
        $todayId = $today->id;

        $todayRequest = Game::where('today_id', $todayId)->where('winner_id', '!=', null);
        $this->todayWinners = $todayRequest->where('winner_id', '!=', 2)->count();
        $this->todayLosers = Game::where('today_id', $todayId)->where('winner_id', 2)->count();
        $fastest = Game::where('today_id', $todayId)->where('winner_id', '!=', null)->where('winner_id', '!=', 2)->orderBy('duration', 'asc')->first();
        if($fastest != null){
            $this->fastName = User::find($fastest->opponent_id)->username;
            $this->fastId = $fastest->id;
            $this->fastValue = $this->secondHuman($fastest->duration);
        }
        $shortest = Game::where('today_id', $todayId)->where('winner_id', '!=', null)->where('winner_id', '!=', 2)->orderBy('guesscount', 'asc')->orderBy('duration', 'asc')->first();
        if($shortest != null){
            $this->shortName = User::find($shortest->opponent_id)->username;
            $this->shortId = $shortest->id;
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
        elseif($game->winner_id == null){
            $this->today = 1;
        }

        $this->todayGame = $game;

        $todayScores = Game::where('user_id', 2)
            ->where('today_id', $todayId)
            ->where('winner_id', '!=', null)
            ->orderBy('duration', 'asc')
            ->orderBy('guesscount', 'asc')
            ->get();
        foreach ($todayScores as $todayScore) {
            if($todayScore->winner_id != 2){
                $this->todays[] = array($todayScore->id, User::find($todayScore->opponent_id)->username, $this->secondHuman($todayScore->duration), $todayScore->guesscount);
            }
        }
    }


    public function new()
    {
        return Auth::user()->opponentGames()->where('seen', 0)->where('user_id', '!=', 2)->where('isduello', null)->orderBy('id', 'desc')->get();
    }

    public function newChallenges()
    {
        return Auth::user()->challenges()->select(['chusers.*'])
            ->join('challenges', 'challenges.id', '=', 'chusers.challenge_id')
            ->where('challenges.winner_id', '=', null)
            ->where('seen', 0)->orderBy('id', 'desc')->get();
    }

    public function newDuellos(){
        return $games =  Game::where('isduello', 1)->where('opponent_id', Auth::id())->where('seen', 0)->whereNull('winner_id')->orderBy('id', 'desc')->get();
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
            ->where('games.isduello', null)
            ->orderBy('guesses.created_at', 'desc')->get();

        $this->gamesMe = $gamesMe->groupBy('id');


        $gamesOpp = Auth::user()->opponentGames()->where('user_id', '!=', 2)->select(['games.*'])
            ->leftJoin('guesses', 'games.id', '=', 'guesses.game_id')
            ->whereNull('winner_id')
            ->where('games.isduello', null)
            ->orderBy('guesses.created_at', 'desc')->get();

        $this->gamesOpp = $gamesOpp->groupBy('id');

        $duellosMe = Game::where('isduello', 1)->where('user_id', Auth::id())->whereNull('winner_id');
        $this->duellos = Game::where('isduello', 1)->where('opponent_id', Auth::id())->whereNull('winner_id')->union($duellosMe)->get();

        return view('livewire.my-games', [
            'user' => Auth::user(),
            'gamesMe' => $this->gamesMe,
            'duellos' => $this->duellos,
            'gamesOpp' => $this->gamesOpp,
            'new' => $this->new(),
            'newChallenges' => $this->newChallenges(),
            'newDuellos' => $this->newDuellos(),
            'activeChallenges' => $this->activeChallenges()
        ]);
    }

    public function secondHuman($second)
    {
        if ($second < 60) {
            $day = 0;
            $hour = 0;
            $min = 0;
            $sec = $second;
        } elseif ($second >= 60 and $second < 3600) {
            $day = 0;
            $hour = 0;
            $min = floor($second / 60);
            $sec = $second % 60;
        } elseif ($second >= 3600 and $second < 86400) {
            $day = 0;
            $hour = floor($second / 3600);
            $min = floor($second / 60);
            $sec = $second % 60;
        } elseif ($second >= 86400) {
            $day = floor($second / 86400);;
            $hour = floor($second / 3600);
            $min = floor($second / 60);
            $sec = $second % 60;
        }

        if ($sec < 10) {
            $sec = "0" . $sec;
        }
        if ($min < 10) {
            $min = "0" . $min;
        }
        if($min == "00"){

            return $sec." sn";
        }
        else{

            return $min." dk ".$sec." sn";
        }
    }
}
