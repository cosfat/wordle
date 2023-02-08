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
        // Her hafta puanları sıfırla
        $schedule->call(function () {
            DB::table('points')->delete();
        })->weeklyOn(1, '08:00');

        // 1 haftadır tahmini veya galibi olmayan klasik oyunları sil
        $schedule->call(function () {
            $games = Game::where('created_at', '<', Carbon::now()->subWeek())->get();
            foreach ($games as $game) {
                if(($game->guesscount == 0 OR $game->winner_id == null)){
                    $game->chats()->where('game_type', 1)->delete();
                    $game->delete();
                }
            }
        })->everyMinute();

        // 1 gündür tahmini olmayan Rekabet oyunlarını sil
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


        // 1 haftadır galibi olmayan Rekabet oyunlarını sil
        $schedule->call(function () {
            $challenges = Challenge::all();
            foreach ($challenges as $challenge) {
                if($challenge->created_at < Carbon::now()->subWeek() AND $challenge->winner_id == null){
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
