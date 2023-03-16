<?php

namespace App\Http\Livewire;

use App\Models\User;
use http\Env\Request;
use Livewire\Component;
use Pusher\Pusher;


class SendNotification extends Component
{

    public function sendNotification()
    {
    }


    public function render()
    {
        return view('livewire.send-notification');
    }
}
