<div>
    <!-- component -->
    <div class="bg-gray-50 border-t mt-4 flex-1 p:2 sm:p-6 justify-between flex flex-col pt-8"
         style="max-height: 20rem; min-height: 2rem; margin-bottom: 8px">
        <div id="messages"
             class="pb-3 flex flex-col space-y-4 overflow-y-auto scrollbar-thumb-blue scrollbar-thumb-rounded scrollbar-track-blue-lighter scrollbar-w-2 scrolling-touch">
            @foreach($messages as $message)
                @if($message->user_id == \Illuminate\Support\Facades\Auth::id())
                    <div class="chat-message">
                        <div class="flex items-end justify-end">
                            <div class="flex flex-col space-y-2 text-xs max-w-xs mx-2 order-1 items-end">
                                <div class="px-4 py-2 rounded-lg inline-block rounded-br-none bg-green-600 ">
                                    <span class="text-white text-sm">{{ $message->message }} </span>
                                    <span class="text-white mt-4" style="font-size: 8px">{{ \Carbon\Carbon::parse($message->created_at)->isoFormat('Do MMMM, h:mm') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="chat-message">
                        <div class="flex items-end">
                            <div class="flex flex-col space-y-2 text-xs max-w-xs mx-2 order-2 items-start">
                                <div class="px-4 py-2 rounded-lg inline-block rounded-br-none bg-green-600 ">
                                    <span class="text-white" style="font-size: 8px">{{ \Carbon\Carbon::parse($message->created_at)->isoFormat('Do MMMM, h:mm') }}</span>
                                    <span class="text-white text-sm"><strong>{{ \App\Models\User::find($message->user_id)->username }}:</strong> {{ $message->message }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        <div class="border-t-2 border-gray-200 px-4 pt-4 sm:mb-0">
            <div class="relative flex" style="z-index: 1 !important;">
                <input id="chatInput" type="text" placeholder="@if($gameType == 1 OR $gameType == 2 OR $gameType == 4) Mesajınızı yazın! @else Günün kelimesi yorumunuz @endif" wire:model="msg"
                       class="w-full border-gray-200 text-gray-600 placeholder-gray-600 p-4 bg-gray-200 rounded-md overflow-hidden">
                <div class="absolute right-0 items-center sm:flex">
                    <div wire:loading.remove wire:target="sendMessage">
                        <button type="button" wire:click="sendMessage"
                                class="inline-flex items-center justify-center bg-gray-200 rounded-lg py-2 text-green-600 focus:outline-none mt-2 mr-2 mb-2">
                            <span class="font-bold">Gönder</span>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                 class="h-6 w-6 ml-2 transform rotate-90">
                                <path
                                    d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path>
                            </svg>
                        </button>
                    </div>
                    <div wire:loading.delay.long wire:target="sendMessage">
                        <button type="button"
                                class="inline-flex items-center justify-center rounded-lg px-4 py-4 text-white bg-gray-500 focus:outline-none">
                            <span class="font-bold">Yükleniyor</span>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                 class="h-6 w-6 ml-2 transform rotate-90">
                                <path
                                    d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .scrollbar-w-2::-webkit-scrollbar {
            width: 0.25rem;
            height: 0.25rem;
        }

        .scrollbar-track-blue-lighter::-webkit-scrollbar-track {
            --bg-opacity: 1;
            background-color: #3730a3;
        }

        .scrollbar-thumb-blue::-webkit-scrollbar-thumb {
            --bg-opacity: 1;
            background-color: #facc15;
        }

        .scrollbar-thumb-rounded::-webkit-scrollbar-thumb {
            border-radius: 0.25rem;
        }
    </style>
    <script type="module">
        @if($gameType == 1)
        window.Echo.private(`sustained-chat.{{ $chatcode }}`)
            .listen('SustchatReceived', (e) => {
                Livewire.emit('refreshChat');
                document.getElementById('messages').scrollTop = document.getElementById('messages').scrollHeight;
            });
        @else
        window.Echo.private(`chat-channel.{{ $gameId }}`)
            .listen('ChatMessaged', (e) => {
                Livewire.emit('refreshChat');
                document.getElementById('messages').scrollTop = document.getElementById('messages').scrollHeight;
            });
        @endif

        document.getElementById('messages').scrollTop = document.getElementById('messages').scrollHeight;

    </script>
    <script>
    </script>
</div>
