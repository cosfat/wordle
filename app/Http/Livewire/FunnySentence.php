<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Orhanerday\OpenAi\OpenAi;

class FunnySentence extends Component
{
    public $word;
    public $credit;
    public $readyToLoad = false;

    public function loadFunny()
    {
        $this->readyToLoad = true;
    }

    public function funnySentence(){
        if($this->credit > 0){
            $open_ai_key = getenv('OPENAI_API_KEY');
            $open_ai = new OpenAi($open_ai_key);

            $complete = $open_ai->chat([
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    [
                        "role" => 'user',
                        "content" => "Amerikan yarışma programı Jeopardy tarzında bir yarışmanın Türkçe versiyonunda '".$this->word."' kelimesini nasıl sorardın?. Lütfen soruda '".$this->word."' kelimesini kullanma ki oyunun heyecanı azalmasın."
                    ]
                ],
                'temperature' => 0.1,
                'max_tokens' => 50,
                'frequency_penalty' => 0,
                'presence_penalty' => 0,
            ]);

            $user = Auth::user();
            if(Auth::id() != 1){
                $user->credit = $this->credit-1;
            }
            $this->credit = $user->credit;
            $user->save();

            // dd($complete);

            $result = json_decode($complete)->choices[0]->message->content;
        }
        else{
            $result = "İpucu hakkın bitti :/";
        }



        return $result;

    }

    public function render()
    {

        $credit = Auth::user()->credit;
        $this->credit = $credit;

        return view('livewire.funny-sentence', [
            'funnyText' => $this->readyToLoad ?  $this->funnySentence() : []
        ]);
    }
}
