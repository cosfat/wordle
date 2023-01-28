<?php

namespace App\Http\Livewire;

use App\Models\Word;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TestCosfat extends Component
{
    public function render()
    {


        $turkler = array(":");
        $turkler2 = array("");

        DB::table('words')->chunkById(100, function ($words) use ($turkler, $turkler2){
            foreach ($words as $word) {
                $name = $word->name;
                $name2 = str_replace($turkler, $turkler2, $name);
                DB::table('words')->where('id', $word->id)->update(['name'=> $name2]);

            }
        });


        return view('livewire.test-cosfat');
    }
}
