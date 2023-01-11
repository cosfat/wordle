<?php

namespace App\Http\Livewire;

use Livewire\Component;

class MyFriends extends Component
{
    public $friends;

    public function render()
    {
        return view('livewire.my-friends');
    }
}
