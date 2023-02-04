<div>
    <!-- component -->
    <div class="flex-1 p:2 sm:p-6 justify-between flex flex-col h-screen pt-8" style="max-height: 20rem;">
        <div id="messages" style="min-height: 2rem"
             class="flex flex-col space-y-4 p-3 overflow-y-auto scrollbar-thumb-blue scrollbar-thumb-rounded scrollbar-track-blue-lighter scrollbar-w-2 scrolling-touch">
            @foreach($messages as $message)
                @if($message->user_id == \Illuminate\Support\Facades\Auth::id())
                    <div class="chat-message">
                        <div class="flex items-end justify-end">
                            <div class="flex flex-col space-y-2 text-xs max-w-xs mx-2 order-1 items-end">
                                <div><span class="px-4 py-2 rounded-lg inline-block rounded-br-none text-gray-500 ">{{ $message->message }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="chat-message">
                        <div class="flex items-end">
                            <div class="flex flex-col space-y-2 text-xs max-w-xs mx-2 order-2 items-start">
                                <div><span
                                        class="px-4 py-2 rounded-lg inline-block rounded-bl-none bg-gray-300 text-indigo-700"><strong>{{ \App\Models\User::find($message->user_id)->username }}:</strong> {{ $message->message }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        <div class="border-t-2 border-gray-200 px-4 pt-4 mb-2 sm:mb-0">
            <div class="relative flex" style="z-index: 1 !important;">
                <input type="text" placeholder="Mesajınızı yazın!" wire:model="msg"
                       class="w-full focus:outline-none focus:placeholder-gray-400 text-gray-600 placeholder-gray-600 pl-12 bg-gray-200 rounded-md py-3 ">
                <div class="absolute right-0 items-center inset-y-0 sm:flex">
                    <button type="button" wire:click="sendMessage"
                            class="inline-flex items-center justify-center rounded-lg px-4 py-3 transition duration-500 ease-in-out text-green-600 bg-blue-500 hover:bg-blue-400 focus:outline-none">
                        <span class="font-bold">Gönder</span>
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

    <style>
        .scrollbar-w-2::-webkit-scrollbar {
            width: 0.25rem;
            height: 0.25rem;
        }

        .scrollbar-track-blue-lighter::-webkit-scrollbar-track {
            --bg-opacity: 1;
            background-color: #f7fafc;
            background-color: rgba(247, 250, 252, var(--bg-opacity));
        }

        .scrollbar-thumb-blue::-webkit-scrollbar-thumb {
            --bg-opacity: 1;
            background-color: #edf2f7;
            background-color: rgba(237, 242, 247, var(--bg-opacity));
        }

        .scrollbar-thumb-rounded::-webkit-scrollbar-thumb {
            border-radius: 0.25rem;
        }
    </style>
<script type="module">
    window.Echo.private(`chat-channel.{{ $gameId }}`)
        .listen('ChatMessaged', (e) => {
            console.log(e.type)
            Livewire.emit('refreshChat');
        });
</script>
    <script>
        const el = document.getElementById('messages')
        el.scrollTop = el.scrollHeight
    </script>
</div>
