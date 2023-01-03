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
Broadcast::channel('game-channel.{gameId}', function ($user, $gameId) {
    $game = Game::find($gameId);
    if ($game->opponent_id == Auth::id()) {
        return true;
    }
else {
    return false;
}
});

    Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
        return (int)$user->id === (int)$id;
    });
