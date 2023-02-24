<?php

namespace App\Http\Livewire;

use App\Models\Game;
use App\Models\Word;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class WordStats extends Component
{
    public function mount(){
        $wordCounts = DB::table('games')
            ->where('user_id', '!=', 2)
        ->select('word_id', DB::raw('COUNT(*) as count'))
        ->groupBy('word_id')
        ->orderByDesc('count')
        ->get();
        foreach ($wordCounts as $wordCount) {
            echo Word::find($wordCount->word_id)->name ." occurs ". $wordCount->count." times.<br>";
        }
    }

    public function render()
    {
        return view('livewire.word-stats');
    }
}
