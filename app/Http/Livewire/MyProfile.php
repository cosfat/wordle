<?php

namespace App\Http\Livewire;

use App\Models\Chat;
use App\Models\Game;
use Livewire\Component;

class MyProfile extends Component
{
    public function render()
    {

     /*   $games = Game::where('user_id', '!=', 2)->get();
        foreach ($games as $game) {
            $usr1 = $game->opponent_id;
            $usr2 = $game->user_id;

            if($usr1 > $usr2){
                $chatHash = $usr1."with".$usr2."hash";
            }
            else{
                $chatHash = $usr2."with".$usr1."hash";
            }
            $game->chatcode = hash('md5', $chatHash);
            $game->save();
        }

        $chats = Chat::where('game_type', 1)->get();
        foreach ($chats as $chat) {
            $game = Game::find($chat->game_id);
            if($game != null){
                $usr1 = $game->opponent_id;
                $usr2 = $game->user_id;

                if($usr1 > $usr2){
                    $chatHash = $usr1."with".$usr2."hash";
                }
                else{
                    $chatHash = $usr2."with".$usr1."hash";
                }
                $chat->chatcode = hash('md5', $chatHash);
                $chat->save();
            }
        }*/
        return view('livewire.my-profile');
    }
}
