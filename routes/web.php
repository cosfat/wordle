<?php

use App\Events\GameNotification;
use App\Models\Word;
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
    Route::get('/finished-challenge-game-watcher/{gameId}/{userId}', \App\Http\Livewire\Watchers\FinishedChallengeGameWatcher::class);
    Route::get('/my-profile', \App\Http\Livewire\MyProfile::class);
    Route::get('/my-games', \App\Http\Livewire\MyGames::class);
    Route::get('/game-logs', \App\Http\Livewire\GameLogs::class);
    Route::get('/create-game', \App\Http\Livewire\CreateGame::class);
    Route::get('/leader-board', \App\Http\Livewire\LeaderBoard::class);
    Route::get('/create-game/{length}', \App\Http\Livewire\CreateGame::class);
    Route::get('/user-summary/{user}', \App\Http\Livewire\UserSummary::class);
});

Route::get('/tdk', function (){

    Word::chunk(50, function ($words){
        $x = 0;
        foreach ($words as $word) {
            if(mb_strlen($word->name, 'UTF-8') == 4){
                $url = "https://sozluk.gov.tr/gts?ara=" . $word->name;
                $json = json_decode(file_get_contents($url), true);
                if (isset($json["error"])) {
                } else {
                    $word->meaning = $json[0]['anlamlarListe'][0]['anlam'];
                    $word->save();
                    $x += 1;
                }
            }
        }
        echo $x;
    });
});

