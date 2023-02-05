<?php

use App\Events\GameNotification;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', \App\Http\Livewire\Welcome::class);

Route::get('/status', 'UserController@userOnlineStatus');
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/the-game/{gameId}', \App\Http\Livewire\TheGame::class);
    Route::get('/the-challenge-game/{gameId}', \App\Http\Livewire\TheChallengeGame::class);
    Route::get('/testcosfat', \App\Http\Livewire\TestCosfat::class);
    Route::get('/game-watcher/{gameId}', \App\Http\Livewire\GameWatcher::class);
    Route::get('/finished-game-watcher/{gameId}', \App\Http\Livewire\FinishedGameWatcher::class);
    Route::get('/finished-challenge-game-watcher/{gameId}', \App\Http\Livewire\FinishedChallengeGameWatcher::class);
    Route::get('/finished-challenge-game-watcher/{gameId}/{userId}', \App\Http\Livewire\FinishedChallengeGameWatcher::class);
    Route::get('/my-profile', \App\Http\Livewire\MyProfile::class);
    Route::get('/my-games', \App\Http\Livewire\MyGames::class);
    Route::get('/game-logs', \App\Http\Livewire\GameLogs::class);
    Route::get('/create-game', \App\Http\Livewire\CreateGame::class);
    Route::get('/leaderboard', \App\Http\Livewire\FriendFeed::class);
    Route::get('/create-game/{length}', \App\Http\Livewire\CreateGame::class);
    Route::get('/user-summary/{user}', \App\Http\Livewire\UserSummary::class);
    Route::get('/user-summary/{user}/{o}', \App\Http\Livewire\UserSummary::class);
});

