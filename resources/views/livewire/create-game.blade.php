<div>
        <form method="POST" action="#" wire:submit.prevent="">
            @if($startGame == false)
                <div class="p-6 grid grid-cols-3 gap-2">
                    <div class="flex justify-center p-5">
                        <h2 class="text-2xl font-bold tracking-tight sm:text-center sm:text-4xl text-indigo-500">Kelime</h2>
                    </div>
                    <div class="flex justify-center p-5">
                        <x-jet-input wire:model.defer="word" wire:blur="checkWord()"
                                     wire:keydown.tab="checkWord()"
                                     wire:keydown.enter="checkWord()" wire:keydown.blur="checkWord()"
                                     placeholder="5 harflik bir kelime seç" id="word" class="mt-1" type="text"
                                     value="{{ $word }}" name="word" required autofocus/>

                        @if($wordError)
                            <p class="mt-2 text-sm text-red-600">Geçersiz kelime</p>
                        @endif
                        <div>
                        </div>
                    </div>
                    <div class="flex justify-center p-5">
                        <button
                            class="px-5 py-3  font-medium text-slate-700 shadow-xl hover:bg-white duration-150 bg-yellow-400"
                            type="button" wire:click="autoWord()">
                            {{ __('Rasgele kelime') }}
                        </button>
                    </div>
                </div>


                @if($hideOpponent == false)
                    <div class="p-6 grid grid-cols-3 gap-2">
                        <div class="flex justify-center p-5">
                            <h2 class="text-2xl font-bold tracking-tight sm:text-center sm:text-4xl text-indigo-500">Rakip</h2>
                        </div>
                        <div class="flex justify-center p-5">
                            <x-jet-input wire:model.defer="opponentEmail" placeholder="E-mail adresi"
                                         id="opponentEmail"
                                         class="mt-1"
                                         type="text" name="opponentEmail" value="{{ $opponentEmail }}"/>

                            @if($opponentError)
                                <div><p class="mt-2 text-sm text-red-600">Geçersiz kullanıcı</p></div>
                            @endif
                        </div>

                        <div class="flex justify-center p-5">
                            <button
                                class="px-5 py-3 font-medium text-slate-700 shadow-xl hover:bg-white duration-150 bg-yellow-400"
                                wire:click="autoOpp()" class="ml-4">
                                {{ __('Rasgele rakip') }}
                            </button>
                        </div>
                    </div>
                    <div class="flex items-center justify-center mt-4">
                        <button
                            class="px-5 py-3 font-medium text-slate-700 shadow-xl hover:bg-white duration-150 bg-yellow-400"
                            wire:click="checkEmail()" class="ml-4">
                            {{ __('Başla') }}
                        </button>
                    </div>
                @endif
            @else
                <script>
                    notifyGame("Oyun başarıyla oluşturuldu.");
                </script>
                <livewire:my-games></livewire:my-games>
            @endif
        </form>
    </div>
</div>
