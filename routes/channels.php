<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
use App\Models\Game;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/
Broadcast::channel('game-channel.{opp}', function ($user, $opp) {

    if(Game::whereOpponent_id($opp)->exists()){
        $game = Game::whereOpponent_id($opp)->first();
        return $user->id === $game->opponent_id;
    }
    else{
        return true;
    }

});

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int)$user->id === (int)$id;
});

