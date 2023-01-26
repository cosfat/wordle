<div>
    @if($startGame == false)

        <form method="POST" action="#" wire:submit.prevent="test">
            <div class="p-5 border-b-2">
                <div class="flex justify-center">
                    <h2>Kelimen kaç harfli olsun?</h2>
                </div>
                <div class="flex justify-center mt-3">
                    <h2 wire:click="changeLength(4)" class="border-2 px-4 py-2 cursor-pointer text-2xl font-bold tracking-tight sm:text-4xl sm:text-center text-indigo-500 ml-3" style="border-color: rgb(250, 204, 21);">4</h2>
                    <h2 wire:click="changeLength(5)" class="border-2 px-4 py-2 cursor-pointer text-2xl font-bold tracking-tight sm:text-4xl sm:text-center text-indigo-500 ml-3" style="border-color: rgb(250, 204, 21);">5</h2>
                    <h2 wire:click="changeLength(6)" class="border-2 px-4 py-2 cursor-pointer text-2xl font-bold tracking-tight sm:text-4xl sm:text-center text-indigo-500 ml-3" style="border-color: rgb(250, 204, 21);">6</h2>
                    <h2 wire:click="changeLength(7)" class="border-2 px-4 py-2 cursor-pointer text-2xl font-bold tracking-tight sm:text-4xl sm:text-center text-indigo-500 ml-3" style="border-color: rgb(250, 204, 21);">7</h2>
                    <h2 wire:click="changeLength(8)" class="border-2 px-4 py-2 cursor-pointer text-2xl font-bold tracking-tight sm:text-4xl sm:text-center text-indigo-500 ml-3" style="border-color: rgb(250, 204, 21);">8</h2>
                </div>
                <div class="flex justify-center mt-3">
                    <x-jet-input wire:model.defer="word"
                                 placeholder="{{ $length }} harflik bir kelime yaz" id="word" class="mt-1" type="text"
                                 value="{{ $word }}" name="word" required autofocus/>

                    <button
                        class="ml-2 px-5 py-3 font-medium text-slate-700 shadow-xl hover:bg-white duration-150 bg-yellow-400"
                        type="button" wire:click="checkWord()">
                        {{ __('Gönder') }}
                    </button>
                    @if ($wordError)
                               <script>notifyGame('Geçersiz kelime')</script>
                    @endif
                </div>

                @if($suggestBoxes)
                <div class="flex justify-center mt-3">
                    @foreach($suggests as $suggest)
                        <button
                            class="mt-1 px-3 py-3 font-medium text-slate-700 shadow-xl hover:bg-white duration-150 bg-yellow-400" type="button" wire:click="pickSuggest('{{ $suggest }}')">
                            {{ $suggest }}
                        </button>

                    @endforeach
                </div>
                @endif
                <div class="flex justify-center">
                    <button
                        class="mt-3 px-5 py-3 font-medium text-slate-700 shadow-xl hover:bg-white duration-150 bg-yellow-400"
                        type="button" wire:click="autoWord()">
                        {{ __('Kelime öner') }}
                    </button>
                </div>
            </div>
        </form>

        @if($hideOpponent == false)
            <form method="POST" action="#" wire:submit.prevent="test">
                <div class="p-5 gap-2 border-b-2">
                    <div class="flex justify-center">
                        <h2 class="text-2xl font-bold tracking-tight sm:text-center sm:text-4xl text-indigo-500">
                            Rakip</h2>
                    </div>
                    <div class="flex justify-center mt-3">
                        <h2>Arkadaşlarımdan seç</h2>
                    </div>
                    <div class="flex justify-center flex-wrap  mt-3">
                        @foreach($suggestFriend as $friend)
                            <button type="button"
                                    class="mt-1 px-5 py-3 font-medium text-slate-700 shadow-xl hover:bg-white duration-150 bg-yellow-400"
                                    wire:click="$set('opponentUserName', '{{ $friend }}')" class="ml-4">
                                {{ $friend }}

                            </button>
                        @endforeach
                    </div>

                    <div class="flex justify-center mt-6">
                        <h2>Kullanıcı adıyla bul</h2>
                    </div>
                    <div class="flex justify-center mt-3">
                        <x-jet-input wire:model.defer="opponentUserName" placeholder="Kullanıcı adı"
                                     id="opponentUserName"
                                     class="mt-1"
                                     type="text" name="opponentUserName" value="{{ $opponentUserName }}"/>
                        <button type="button"
                                class="ml-2 px-5 py-3 font-medium text-slate-700 shadow-xl hover:bg-white duration-150 bg-yellow-400"
                                wire:click="checkEmail()" class="ml-4">
                            {{ __('Gönder') }}
                        </button>

                        @if($opponentError)
                            @if($existingGameError)
                                <script>notifyGame('Bu kullanıcıya zaten oyun gönderdiniz')</script>
                            @else
                                <script>notifyGame('Geçersiz kullanıcı')</script>
                                @endif
                        @endif
                    </div>

                    <div class="flex justify-center mt-6">
                        <h2>Rasgele oyuncu bul</h2>
                    </div>
                    <div class="flex justify-center mt-3">
                        <button type="button"
                                class="mt-1 px-5 py-3 font-medium text-slate-700 shadow-xl hover:bg-white duration-150 bg-yellow-400"
                                wire:click="autoOpp()" class="ml-4">
                            {{ __('Rasgele rakip') }}
                        </button>
                    </div>
                </div>

            </form>
        @endif
    @endif

        @if (session()->has('message'))
            <script>
                notifyGame("{{  session('message')  }}")
            </script>
        @endif
</div>
