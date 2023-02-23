<?php

namespace App\Http\Livewire;

use App\Events\ChatMessaged;
use App\Events\SustchatReceived;
use App\Models\Challenge;
use App\Models\Game;
use App\Models\Chat;
use App\Models\Today;
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
    public $multichat;
    public $chatcode;

    public function mount(){
        if($this->gameType == 1){
            $this->game = Game::find($this->gameId);
        }
        elseif($this->gameType == 2 OR $this->gameType == 4){
            $this->game = Challenge::find($this->gameId);
        }
        else{
            $this->gameId = Game::find($this->gameId)->id;
        }
    }

    public function sendMessage(){
        $msg = $this->msg;
        if($msg!=null){
            $chat = new Chat();
            if($this->gameType == 4){
                $chat->game_id = $this->multichat;
            }
            else{
                $chat->game_id = $this->gameId;
            }
            $chat->user_id = Auth::id();
            $chat->message = $msg;
            if($this->gameType == 1){
                $chat->game_type = $this->gameType;
                SustchatReceived::dispatch($this->chatcode);
            }
            else if($this->gameType == 2 OR $this->gameType == 4){
                $chat->game_type = $this->gameType;
                ChatMessaged::dispatch($this->gameId, $this->gameType);
            }
            else{
                $chat->seen = 1;
                $chat->game_type = $this->gameType;
            }
            $chat->user_id = Auth::id();
            $chat->chatcode = $this->chatcode;
            $chat->save();
            $this->emit('refreshChat');
            $this->msg = "";
        }

    }

    public function render()
    {
        if($this->gameType == 1){
            $chats = Chat::where('chatcode', $this->chatcode);
        }
        else if($this->gameType == 2){
            $chats = $this->game->chats()->where('game_type', $this->gameType);
        }
        else if($this->gameType == 4){
            $chats = Chat::where('game_type', 4)->where('game_id', $this->multichat);
        }
        else {
            $chats = Chat::where('game_type', $this->gameType);
        }
        $this->messages = $chats->orderBy('id', 'desc')->limit(30)->reOrder('id', 'asc')->get();
        $myChats = $chats->where('user_id', '!=', Auth::id())->where('seen', 0)->get();
        if($this->gameType == 1 OR $this->gameType == 2){
            foreach ($myChats as $chat) {
                $chat->seen = 1;
                $chat->save();
            }
        }
        return view('livewire.chat-wire', [
            'messages' => $this->messages
        ]);
    }
}
