<div>
    @if($startGame == false)

        <form method="POST" action="#" wire:submit.prevent="test">
            <div class="p-5 gap-2 border-b-2">
                <div class="flex justify-center">
                    <h2 class="text-2xl font-bold tracking-tight sm:text-center sm:text-4xl text-indigo-500">Kelime</h2>
                </div>
                <div class="flex justify-center">
                    <x-jet-input wire:model.defer="word"
                                 placeholder="5 harflik bir kelime seç" id="word" class="mt-1" type="text"
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

                <div class="flex justify-center">
                    <button
                        class="mt-1 px-5 py-3 font-medium text-slate-700 shadow-xl hover:bg-white duration-150 bg-yellow-400"
                        type="button" wire:click="autoWord()">
                        {{ __('Rasgele kelime') }}
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

                    <div class="flex justify-center">
                        <x-jet-input wire:model.defer="opponentEmail" placeholder="E-mail adresi"
                                     id="opponentEmail"
                                     class="mt-1"
                                     type="text" name="opponentEmail" value="{{ $opponentEmail }}"/>
                        <button type="button"
                                class="ml-2 px-5 py-3 font-medium text-slate-700 shadow-xl hover:bg-white duration-150 bg-yellow-400"
                                wire:click="checkEmail()" class="ml-4">
                            {{ __('Gönder') }}
                        </button>

                        @if($opponentError)
                            <script>notifyGame('Geçersiz kullanıcı')</script>
                        @endif
                    </div>

                    <div class="flex justify-center">
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
