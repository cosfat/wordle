<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
use App\Models\Game;
use App\Models\Chuser;

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

    if (Game::whereOpponent_id($opp)->exists()) {
        $game = Game::whereOpponent_id($opp)->first();
        return $user->id === $game->opponent_id;
    } else {
        return true;
    }

});

Broadcast::channel('chat-channel.{game}', function ($user, $game) {

        return Game::where('id', $game)->where('user_id', $user->id)->exists() OR
            Game::where('id', $game)->where('opponent_id', $user->id)->exists()

   OR Chuser::where('challenge_id', $game)->where('user_id', $user->id)->exists();


});

Broadcast::channel('guesses-channel.{opp}', function ($user, $opp) {

    if (Game::whereOpponent_id($opp)->exists()) {
        $game = Game::whereOpponent_id($opp)->first();
        return $user->id === $game->opponent_id;
    } else {
        return true;
    }

});

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int)$user->id === (int)$id;
});

