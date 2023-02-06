<?php

namespace App\Console;

use App\Models\Challenge;
use App\Models\Game;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            DB::table('points')->delete();
        })->weeklyOn(1, '08:00');


        $schedule->call(function () {
            $games = Game::all();
            foreach ($games as $game) {
                if($game->guesses()->count() == 0 AND $game->created_at < Carbon::now()->subWeek()){
                    $game->chats()->where('game_type', 1)->delete();
                    $game->delete();
                }
            }
        })->hourly();


        $schedule->call(function () {
            $challenges = Challenge::all();
            foreach ($challenges as $challenge) {
                if($challenge->chguesses()->count() == 0 AND $challenge->created_at < Carbon::now()->subDay()){
                    $challenge->chats()->where('game_type', 2)->delete();
                    $challenge->chusers()->delete();
                    $challenge->delete();
                }
            }
        })->hourly();

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
