<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 flex justify-center items-center">
                @if($startGame == false)
                    <form method="POST" action="#" wire:submit.prevent="">
                        <div>
                            <x-jet-label for="word" value="{{ __('Word') }}"/>
                            <x-jet-input wire:model.defer="word" wire:blur="checkWord()" wire:keydown.tab="checkWord()"
                                         wire:keydown.enter="checkWord()" wire:keydown.blur="checkWord()"
                                         placeholder="Max 5 letters" id="word" class="mt-1" type="text"
                                         value="{{ $word }}" name="word" required autofocus/>
                            <div>
                                @if($wordError)
                                    <p class="mt-2 text-sm text-red-600">Geçersiz kelime</p>
                                @endif
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-jet-button type="button" wire:click="autoWord()" class="ml-4">
                                {{ __('Auto Word') }}
                            </x-jet-button>
                        </div>

                        @if($hideOpponent == false)
                            <div class="mt-4">
                                <x-jet-label for="opponentEmail" value="{{ __('Opponent Email') }}"/>

                                <x-jet-input wire:model.defer="opponentEmail" placeholder="Opponent email"
                                             id="opponentEmail"
                                             class="mt-1"
                                             type="text" name="opponentEmail" value="{{ $opponentEmail }}"/>
                                <div>
                                    @if($opponentError)
                                        <p class="mt-2 text-sm text-red-600">Geçersiz kullanıcı</p>
                                    @endif
                                </div>
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <x-jet-button wire:click="checkEmail()" class="ml-4">
                                    {{ __('Check Email') }}
                                </x-jet-button>
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <x-jet-button wire:click="autoOpp()" class="ml-4">
                                    {{ __('Automatic Opponent') }}
                                </x-jet-button>
                            </div>
                        @endif
                        @else
                            {{ \App\Models\Word::find($gameWord)->name }}<br>{{ \App\Models\User::find($gameOpp)->name }}
                        @endif
                    </form>
            </div>
        </div>
    </div>
</div>
