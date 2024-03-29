<?php
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
// Route::get('/status', [\App\Http\Controllers\UserController::class, 'userOnlineStatus']);
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/the-game/{gameId}', \App\Http\Livewire\Games\TheGame::class);
    Route::get('/the-game/{gameId}/{duello}', \App\Http\Livewire\Games\TheGame::class);
    Route::get('/the-challenge-game/{gameId}', \App\Http\Livewire\Games\TheChallengeGame::class);
    Route::get('/game-watcher/{gameId}', \App\Http\Livewire\Watchers\GameWatcher::class);
    Route::get('/finished-game-watcher/{gameId}', \App\Http\Livewire\Watchers\FinishedGameWatcher::class);
    Route::get('/finished-game-watcher/{gameId}/{duello}', \App\Http\Livewire\Watchers\FinishedGameWatcher::class);
    Route::get('/finished-challenge-game-watcher/{gameId}', \App\Http\Livewire\Watchers\FinishedChallengeGameWatcher::class);
    Route::get('/replay-challenge-game-watcher/{gameId}/{replay}', \App\Http\Livewire\Watchers\FinishedChallengeGameWatcher::class);
    Route::get('/finished-challenge-game-watcher/{gameId}/{userId}', \App\Http\Livewire\Watchers\FinishedChallengeGameWatcher::class);
    Route::get('/my-profile', \App\Http\Livewire\MyProfile::class);
    Route::get('/my-games', \App\Http\Livewire\MyGames::class);
    Route::get('/word-stats', \App\Http\Livewire\WordStats::class);
    Route::get('/game-logs', \App\Http\Livewire\GameLogs::class);
    Route::get('/create-game', \App\Http\Livewire\CreateGame::class);
    Route::get('/leader-board', \App\Http\Livewire\LeaderBoard::class);
    Route::get('/send-notification', \App\Http\Livewire\SendNotification::class);
    Route::get('/create-game/{length}', \App\Http\Livewire\CreateGame::class);
    Route::get('/user-summary/{user}', \App\Http\Livewire\UserSummary::class);
});
