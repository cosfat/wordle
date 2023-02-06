<?php

namespace App\Http\Livewire;

use App\Models\Challenge;
use App\Models\Chguess;
use App\Models\Chuser;
use App\Models\Game;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class GameLogs extends Component
{
    public $notes = array();
    public $notesMe = array();
    public $notesCh = array();
    public $mode;
    protected $listeners = ['refreshLogs' => '$refresh'];

    public function mount(){
        $this->mode = 1;
    }

    public function render()
    {

        if($this->mode == 1){
            $chusers = Chuser::where('user_id', Auth::id())->orderBy('id', 'desc')->limit(20)->get();
            $x = 0;
            foreach ($chusers as $chuser) {
                $challenge = $chuser->challenge()->first();
                $guessesCount =$challenge->guesscount;
                $length = $challenge->length;
                $userCount = $challenge->usercount;
                $shouldTotal = $userCount * ($length + 1);
                if($challenge->winner_id != null){
                    $this->notesCh[$x]['user'] = User::whereId($challenge->winner_id)->first()->username;
                    $this->notesCh[$x]['word'] = $challenge->word->name;
                    $this->notesCh[$x]['link'] = $challenge->id;
                    if($challenge->chats()->where('user_id', '!=', Auth::id())->where('game_type', 2)->where('seen', 0)->exists())
                    {
                        $this->notesCh[$x]['chat'] = true;
                    }
                    else{
                        $this->notesCh[$x]['chat'] = false;
                    }
                    if($challenge->winner_id != Auth::id()){
                        $this->notesCh[$x]['status'] = 1;
                    }else {
                        $this->notesCh[$x]['status'] = 2;
                    }

                }
                elseif($guessesCount == $shouldTotal){
                    $this->notesCh[$x]['user'] = "Kimse bilemedi";
                    $this->notesCh[$x]['word'] = $challenge->word->name;
                    $this->notesCh[$x]['link'] = $challenge->id;
                    $this->notesCh[$x]['status'] = 3;
                    if($challenge->chats()->where('user_id', '!=', Auth::id())->where('game_type', 2)->where('seen', 0)->exists())
                    {
                        $this->notesCh[$x]['chat'] = true;
                    }
                    else{
                        $this->notesCh[$x]['chat'] = false;
                    }
                }

                $x += 1;
            }
        }
        elseif($this->mode == 2){
            $finished = Game::where('user_id', Auth::id())->where('winner_id', '!=', null)->orderBy('updated_at', 'desc')->limit(20)->get();
            $x = 0;
            foreach ($finished as $game) {
                $guesses = $game->guesses();
                $username = User::whereId($game->opponent_id)->first()->username;
                $count = $guesses->count();
                $word = $game->word->name;

                if($game->chats()->where('user_id', '!=', Auth::id())->where('game_type', 1)->where('seen', 0)->exists())
                {
                    $this->notes[$x]['chat'] = true;
                }
                else{
                    $this->notes[$x]['chat'] = false;
                }

                $this->notes[$x]['user'] = $username;
                $this->notes[$x]['word'] = $word;
                $this->notes[$x]['link'] = $game->id;

                if ($game->winner_id != Auth::id()) {
                    $this->notes[$x]['status'] = 1;
                    $this->notes[$x]['count'] = $count;
                } else {
                    $this->notes[$x]['status'] = 0;
                }
                $x += 1;
            }
        }
        else {
            $finishedMe = Game::where('opponent_id', Auth::id())->where('winner_id', '!=', null)->orderBy('updated_at', 'desc')->limit(20)->get();
            $x = 0;
            foreach ($finishedMe as $game) {
                $guesses = $game->guesses();
                $username = User::whereId($game->user_id)->first()->username;
                $count = $guesses->count();
                $word = $game->word->name;

                if($game->chats()->where('user_id', '!=', Auth::id())->where('game_type', 1)->where('seen', 0)->exists())
                {
                    $this->notesMe[$x]['chat'] = true;
                }
                else{
                    $this->notesMe[$x]['chat'] = false;
                }

                $this->notesMe[$x]['user'] = $username;
                $this->notesMe[$x]['word'] = $word;
                $this->notesMe[$x]['link'] = $game->id;

                if ($game->winner_id == Auth::id()) {
                    $this->notesMe[$x]['status'] = 1;
                    $this->notesMe[$x]['count'] = $count;
                } else {
                    $this->notesMe[$x]['status'] = 0;
                }
                $x += 1;

            }

        }
        return view('livewire.game-logs');
    }
}
