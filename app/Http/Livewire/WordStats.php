<?php

namespace App\Http\Livewire;

use App\Models\Game;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class WordStats extends Component
{
    public function mount(){
        $classics = DB::table('games')
        ->select(['word_id', DB::raw('count(*) as total')])
            ->where('isduello', null)
            ->where('user_id', '!=', 2)
            ->where('winner_id', '!=', 'user_id')
            ->where('winner_id', '!=', null)
            ->orderBy('total')
            ->get();
        $classics = $classics->groupBy('word_id');
        foreach ($classics as $classic) {
            if($classic->count() > 1){
                echo $classic[0]->word->name."-".$classic->count()."<br>";
            }
        }
    }

    public function render()
    {
        return view('livewire.word-stats');
    }
}
