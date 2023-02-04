<?php

namespace App\Http\Livewire;

use App\Events\ChatMessaged;
use App\Models\Challenge;
use App\Models\Game;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ChatWire extends Component
{
    protected $messages;
    protected $listeners = ['refreshChat' => '$refresh'];

    public $msg;
    public $gameId;
    public $gameType;
    public $userName;

    public function sendMessage(){
        $msg = $this->msg;
        if($msg!=null){
            $chat = new Chat();
            $chat->game_id = $this->gameId;
            $chat->game_type = $this->gameType;
            $chat->user_id = Auth::id();
            $chat->message = $msg;
            $chat->save();

            ChatMessaged::dispatch($this->gameId, $this->gameType);
            $this->emit('refreshChat');
            $this->msg = "";
        }

    }

    public function refreshC(){

    }

    public function render()
    {
        $this->messages = Chat::where('game_id', $this->gameId)->where('game_type', $this->gameType)->orderBy('id', 'desc')->limit(30);
        $this->messages = $this->messages->reOrder('id', 'asc')->get();


        return view('livewire.chat-wire', [
            'messages' => $this->messages
        ]);
    }
}
