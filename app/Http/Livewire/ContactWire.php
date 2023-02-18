<?php

namespace App\Http\Livewire;

use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ContactWire extends Component
{
    public $userId;
    public $friend;
    public $message = "Arkadaş ekle";
    public $isContact = 0;

    public function mount($friend){
        $this->userId = Auth::id();
        $this->friend = $friend;
        if(Auth::user()->contacts()->where('contact_id', $this->friend)->exists()){
            $this->message = "Arkadaşlıktan çıkar";
            $this->isContact = 1;
        }
        else{
            $this->message = "Arkadaş ekle";
            $this->isContact = 0;
        }
    }

    public function state(){
        $userId = $this->userId;

        if(Auth::user()->contacts()->where('contact_id', $this->friend)->doesntExist()){
            $contact = new Contact();
            $contact->contact_id = $this->friend;
            $contact->user_id = $userId;
            $contact->save();
            $this->message = "Arkadaş olarak eklendi";
            $this->isContact = 1;
        }
        else{
            Auth::user()->contacts()->where('contact_id', $this->friend)->first()->delete();
            $this->message = "Arkadaş ekle";
            $this->isContact = 0;
        }
    }

    public function render()
    {
        return view('livewire.contact-wire');
    }
}
