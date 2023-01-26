<div name="my-games" class="py-4">
        <div class="p-5 gap-2 border-b-2">
            <div class="flex flex-wrap">
                <h2 class="text-2xl font-bold tracking-tight sm:text-center sm:text-4xl text-indigo-500">
                    Oyun isteklerim</h2>
            </div>
            <div class="flex flex-wrap">
                @if($gamesOp->count() == 0)
                    <p>Hiç oyun isteğin yok, oyunu arkadaşlarına tavsiye edebilirsin!</p>

                @endif
            @foreach($gamesOp as $game)
                <a href="/the-game/{{ $game->id }}">
                    <div class="p-10 flex flex-col  items-center text-center group hover:bg-slate-50 cursor-pointer">
                        @if($game->seen == 0)
                            <div
                                class="absolute inline-flex items-center justify-center p-2 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full">
                                Yeni oyun
                            </div>
                        @endif
                        <span class="p-5 rounded-full bg-red-500 text-white shadow-lg shadow-red-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </span>

                        <p class="text-xl font-medium text-slate-700 mt-3">
                            {{ substr($game->user->name, 0, 9)}}
                        </p>

                        <p class="mt-2 text-sm text-slate-500">
                            *****
                        </p>
                    </div>
                </a>
            @endforeach

            </div>
        </div>


        <div class="p-5 gap-2 border-b-2">
            <div class="flex flex-wrap">
                <h2 class="text-2xl font-bold tracking-tight sm:text-center sm:text-4xl text-indigo-500">
                    Gönderdiğim oyunlar</h2>
            </div>
            <div class="flex flex-wrap">

                @if($gamesMe->count() == 0)
                    <p>Hiç oyun göndermediniz, yeni oyun <a href="/create-game" class="text-indigo-500">başlatmak için tıkla!</a></p>
                @endif
            @foreach($gamesMe as $game)

                <a href="/game-watcher/{{ $game->id }}">
                    <div class="p-10 flex flex-col items-center text-center group hover:bg-slate-50 cursor-pointer">
                        <span class="p-5 rounded-full bg-indigo-500 text-white shadow-lg shadow-indigo-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </span>
                        <p class="text-xl font-medium text-slate-700 mt-3">
                            {{ substr(\App\Models\User::whereId($game->opponent_id)->first()->username, 0, 9) }}
                        </p>
                        <p class="mt-2 text-sm text-slate-500">
                            {{ $game->word->name }}
                        </p>
                    </div>
                </a>
            @endforeach
            </div>
        </div>
    </div>

    @if (session()->has('message'))
        <script>
            notifyGame("{{  session('message')  }}")
        </script>
    @endif
