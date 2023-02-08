<?php

namespace App\Http\Livewire;

use Livewire\Component;

class LiveCounter extends Component
{

    public $start;
    public $counting = false;
    public $firstGuess;
    public $d;
    public $h;
    public $m;
    public $s;

    protected $listeners = ['startCounterFirstTime'];

    public function startCounterFirstTime(){

        $this->counting = true;

    }

    public function mount(){
        if($this->firstGuess == false){
            $this->counting = true;
        }
    }

    public function render()
    {
        if($this->start < 60)
        {
            $this->d = 0;
            $this->h = 0;
            $this->m = 0;
            $this->s = $this->start;
        }
        elseif ($this->start >= 60 AND $this->start < 3600){
            $this->d = 0;
            $this->h = 0;
            $this->m = floor( $this->start / 60);
            $this->s = $this->start % 60;
        }
        elseif ($this->start >= 3600 AND $this->start < 86400){
            $this->d = 0;
            $this->h = floor( $this->start / 3600);
            $this->m = floor( $this->start / 60);
            $this->s = $this->start % 60;
        }
        elseif ($this->start >= 86400){
            $this->d = floor( $this->start / 86400);;
            $this->h = floor( $this->start / 3600);
            $this->m = floor( $this->start / 60);
            $this->s = $this->start % 60;
        }

        return view('livewire.live-counter');
    }
}
