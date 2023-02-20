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
                $this->ratio = round(($winGames / ($winGames + $lostGames)) * 100, 1);
            }
            if($this->ratio == 0){
                $this->level = "Oralı değil";
            }
            elseif ($this->ratio > 0 AND $this->ratio <= 10){
                $this->level = "Çevresi kötü";
            }
            elseif ($this->ratio > 10 AND $this->ratio <= 20){
                $this->level = "Zeki ama çalışmıyor";
            }
            elseif ($this->ratio > 20 AND $this->ratio <= 30){
                $this->level = "Demet Akalın öğrencisi";
            }
            elseif ($this->ratio > 30 AND $this->ratio <= 40){
                $this->level = "Orhan Pamuk hayranı";
            }
            elseif ($this->ratio > 40 AND $this->ratio <= 50){
                $this->level = "Cambaz";
            }
            elseif ($this->ratio > 50 AND $this->ratio <= 60){
                $this->level = "Fen liseli";
            }
            elseif ($this->ratio > 60 AND $this->ratio <= 70){
                $this->level = "Repçi";
            }
            elseif ($this->ratio > 70 AND $this->ratio <= 80){
                $this->level = "Sözelci";
            }
            elseif ($this->ratio > 80 AND $this->ratio <= 90){
                $this->level = "Servet-i Fünun";
            }
            elseif ($this->ratio > 90 AND $this->ratio <= 95){
                $this->level = "İlber Ortaylı";
            }
            elseif ($this->ratio > 95 AND $this->ratio <= 99){
                $this->level = "Allame-i Cihan";
            }
            elseif ($this->ratio > 99){
                $this->level = "İnsan değil";
            }
            $this->winGames = $winGames;
            $this->lostGames = $lostGames;
        } else {
            return redirect('/my-games');
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
