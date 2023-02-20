<?php

namespace App\Http\Livewire;

use App\Models\Challenge;
use App\Models\Chuser;
use App\Models\Game;
use App\Models\Today;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserSummary extends Component
{
    protected $games;
    protected $user;
    public $ratio;
    public $todayId;
    public $winGames = 0;
    public $lostGames = 0;
    public $level = 0;

    public function mount($user)
    {
        if ($user != 2) {
            $this->todayId = Today::orderBy('id', 'desc')->first()->id;
            $challengeGames = array();
            $this->user = User::findOrFail($user);
            $ngames = User::find($user)->opponentGames()->orderBy('id', 'desc')->limit(10)->pluck('id');
            $chgames = User::find($user)->challenges()->orderBy('id', 'desc')->limit(10)->pluck('challenge_id');

            foreach ($ngames as $game) {
                $this->games[] = Game::find($game);
            }

            foreach ($chgames as $chgame) {
                $challengeGames[] = Challenge::find($chgame);
            }

            foreach ($challengeGames as $challengeGame) {
                $this->games[] = $challengeGame;
            }

            if ($this->games != null) {

                usort($this->games, fn($a, $b) => $b['created_at'] <=> $a['created_at']);
            }

            $winGames = Game::where('winner_id', $this->user->id)->count() + Challenge::where('winner_id', $this->user->id)->count();
            $lostGames = Game::where('opponent_id', $this->user->id)
                ->where('winner_id', '!=', $this->user->id)
                ->where('winner_id', '!=', null)
                ->count();


            $chusers = Chuser::where('user_id', $this->user->id)->get();
            $x = 0;
            foreach ($chusers as $item) {
                if (Challenge::where('id', $item->challenge_id)->where('winner_id', '!=', $this->user->id)->exists()) {
                    $x += 1;
                }
            }
            $lostGames = $x + $lostGames;

            if ($winGames + $lostGames == 0) {
                $this->ratio = 0;
            } else {
                $this->ratio = round(($winGames / ($winGames + $lostGames)) * 100);
            }

            $this->level = $this->getLevel($this->ratio);



            $this->winGames = $winGames;
            $this->lostGames = $lostGames;
        } else {
            return redirect('/my-games');
        }

    }

    public function getLevel($ratio){
        if($ratio == 0){
            return "Oralı değil";
        }
        elseif ($ratio > 0 AND $ratio <= 10){
            return "Çevresi kötü";
        }
        elseif ($ratio > 10 AND $ratio <= 20){
            return "Zeki ama çalışmıyor";
        }
        elseif ($ratio > 20 AND $ratio <= 30){
            return "Demet Akalın öğrencisi";
        }
        elseif ($ratio > 30 AND $ratio <= 40){
            return "Orhan Pamuk hayranı";
        }
        elseif ($ratio > 40 AND $ratio <= 50){
            return "Cambaz";
        }
        elseif ($ratio > 50 AND $ratio <= 60){
            return "Fen liseli";
        }
        elseif ($ratio > 60 AND $ratio <= 70){
            return "Repçi";
        }
        elseif ($ratio > 70 AND $ratio <= 80){
            return "Sözelci";
        }
        elseif ($ratio > 80 AND $ratio <= 90){
            return "Servet-i Fünun";
        }
        elseif ($ratio > 90 AND $ratio <= 95){
            return "İlber Ortaylı";
        }
        elseif ($ratio > 95 AND $ratio <= 99){
            return "Allame-i Cihan";
        }
        elseif ($ratio > 99){
            return "İnsan değil";
        }
    }

    public function render()
    {
        return view('livewire.user-summary', [
            'games' => $this->games,
            'user' => $this->user,
        ]);
    }
}
