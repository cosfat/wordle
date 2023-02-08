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
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Her hafta puanları sıfırla
        $schedule->call(function () {
            DB::table('points')->delete();
        })->weeklyOn(1, '08:00');

        // 1 haftadır galibi olmayan klasik oyunları sil
        $schedule->call(function () {
            $games = Game::where('created_at', '<', Carbon::now()->subWeek())
                ->whereNull('winner_id')->get();
            foreach ($games as $game) {
                $game->chats()->where('game_type', 1)->delete();
                $game->delete();
            }
        })->everyMinute();

        // 1 haftadır galibi olmayan Rekabet oyunlarını sil
        $schedule->call(function () {
            $challenges = Challenge::where('created_at', '<', Carbon::now()->subWeek())->whereNull('winner_id')->get();
            foreach ($challenges as $challenge) {
                $challenge->chats()->where('game_type', 2)->delete();
                $challenge->chusers()->delete();
                $challenge->delete();
            }
        })->everyMinute();

        // 1 gündür tahmini olmayan klasik oyunları sil
        $schedule->call(function () {
            $games = Game::where('created_at', '<', Carbon::now()->subDay())
                ->where('guesscount', 0)->get();
            foreach ($games as $game) {
                $game->chats()->where('game_type', 1)->delete();
                $game->delete();
            }
        })->everyMinute();

        // 1 gündür tahmini olmayan Rekabet oyunlarını sil
        $schedule->call(function () {
            $challenges = Challenge::where('guesscount', 0)->where('created_at', '<', Carbon::now()->subDay())->get();
            foreach ($challenges as $challenge) {
                $challenge->chats()->where('game_type', 2)->delete();
                $challenge->chusers()->delete();
                $challenge->delete();
            }
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
