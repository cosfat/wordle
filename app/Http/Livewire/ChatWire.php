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
    public $game;

    public function mount(){
        if($this->gameType == 1){
            $this->game = Game::find($this->gameId);
        }
        else{
            $this->game = Challenge::find($this->gameId);
        }
    }

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

    public function render()
    {
        $chats = $this->game->chats();
        $this->messages = $chats->orderBy('id', 'desc')->limit(30)->reOrder('id', 'asc')->get();
        $myChats = $chats->where('user_id', '!=', Auth::id())->where('seen', 0)->get();
        foreach ($myChats as $chat) {
            $chat->seen = 1;
            $chat->save();
        }
        return view('livewire.chat-wire', [
            'messages' => $this->messages
        ]);
    }
}
