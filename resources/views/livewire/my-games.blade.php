<div name="my-games" class="py-4">
    @include('loading')
    <div class="p-5 gap-2 border-b-2">
        <div class="flex flex-wrap">
            <h2 class="text-2xl font-bold tracking-tight sm:text-center sm:text-4xl text-indigo-500">
                Yeni oyun isteklerim</h2>
        </div>
        <div class="flex flex-wrap">
            @if($new->count() == 0 AND $newChallenges->count() == 0)
                <p>Hiç oyun isteğin yok, oyunu arkadaşlarına tavsiye edebilirsin!</p>
            @endif

            @foreach($newChallenges as $game)
                    <a href="/the-challenge-game/{{ $game->challenge_id }}">
                        <div class="p-4 flex flex-col  items-center text-center group hover:bg-slate-50 cursor-pointer">
                            <div
                                class="absolute mt-3 inline-flex items-center justify-center p-2 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full">
                                Yeni oyun
                            </div>
                            <span class="p-2 rounded-full bg-yellow-400 text-white shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </span>

                            <p class="text-xl font-medium text-slate-700 mt-3">
                                <strong>
                                    {{ substr($game->challenge->user->name, 0, 9)}}
                                </strong>
                            </p>
                            <p>{{ $game->challenge->usercount }} kişi</p>
                            <p class="text-sm text-gray-600">{{ $game->created_at->diffForHumans(\Carbon\Carbon::now()) }}</p>
                        </div>
                    </a>
            @endforeach
            @foreach($new as $game)
                <a href="/the-game/{{ $game->id }}">
                    <div class="p-4 flex flex-col  items-center text-center group hover:bg-slate-50 cursor-pointer">
                        <div
                            class="absolute mt-3 inline-flex items-center justify-center p-2 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full">
                            Yeni oyun
                        </div>
                        <span class="p-2 rounded-full bg-red-500 text-white shadow-lg shadow-red-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </span>

                        <p class="text-xl font-medium text-slate-700 mt-3">
                            <strong>
                                {{ substr($game->user->name, 0, 9)}}
                            </strong>
                        </p>
                        <p class="text-sm text-gray-600">{{ $game->created_at->diffForHumans(\Carbon\Carbon::now()) }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
    <div class="p-5 gap-2 border-b-2">
        <div class="flex flex-wrap">
            <h2 class="text-2xl font-bold tracking-tight sm:text-center sm:text-4xl text-indigo-500">
                Aktif rekabet oyunlarım</h2>
        </div>
        <div class="flex flex-wrap">
            @if(count($activeChallenges) == 0)
                <p>Hiç aktif rekabet oyunun yok, <a href="/create-game" class="text-indigo-500">şimdi oyun başlat!</a>
                </p>
            @endif
            @foreach($activeChallenges as $game)
                <a href="/the-challenge-game/{{ $game->challenge_id }}">
                    <div class="p-4 flex flex-col  items-center text-center group hover:bg-slate-50 cursor-pointer">
                                                <span class="p-2 rounded-full bg-yellow-400 text-white shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </span>

                        <p class="text-xl font-medium text-slate-700 mt-3">
                            <strong>
                                {{ substr($game->challenge->user->name, 0, 9)}}
                            </strong>
                        </p>
                        <p>{{ $game->challenge->usercount }} kişi</p>
                        <p class="text-sm text-gray-600">{{ $game->created_at->diffForHumans(\Carbon\Carbon::now()) }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>


    <div class="p-4 gap-2 border-b-2">
        <div class="flex flex-wrap">
            <h2 class="text-2xl font-bold tracking-tight sm:text-center sm:text-4xl text-indigo-500">
                Aktif klasik oyunlarım</h2>
        </div>
        <div class="flex flex-wrap">
            @if($gamesOpp->count() == 0)
                <p>Hiç oyunun yok, yeni oyun <a href="/create-game" class="text-indigo-500">başlatmak için tıkla!</a>
                </p>
            @endif
            @foreach($gamesOpp as $game)
                <a href="/the-game/{{ $game[0]->id }}">
                    <div
                        class="p-4 flex flex-col items-center text-center group hover:bg-slate-50 cursor-pointer">
                        <span class="p-2 rounded-full
                        bg-red-500 shadow-red-200
                        text-white shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </span>
                        <p class="text-xl font-medium text-slate-700 mt-3">
                            {{ substr(\App\Models\User::whereId($game[0]->user_id)->first()->username, 0, 9) }}
                        </p>
                        <p class="text-sm text-gray-600">{{ $game[0]->created_at->diffForHumans(\Carbon\Carbon::now()) }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
    <div class="p-4 gap-2 border-b-2">
        <div class="flex flex-wrap">
            <h2 class="text-2xl font-bold tracking-tight sm:text-center sm:text-4xl text-indigo-500">
                Sorduklarım</h2>
        </div>
        <div class="flex flex-wrap">
            @if($gamesMe->count() == 0)
                <p>Hiç oyunun yok, yeni oyun <a href="/create-game" class="text-indigo-500">başlatmak için tıkla!</a>
                </p>
            @endif
            @foreach($gamesMe as $game)
                <a href="/game-watcher/{{ $game[0]->id }}">
                    <div
                        class="p-4 flex flex-col items-center text-center group hover:bg-slate-50 cursor-pointer">
                        @if($game[0]->seen2==0)
                            <div
                                class="absolute ml-12 inline-flex items-center justify-center">
                                <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                                     xmlns="http://www.w3.org/2000/svg" stroke="#EF4444"
                                     stroke-width="0.00024000000000000003">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path
                                            d="M19.3399 14.49L18.3399 12.83C18.1299 12.46 17.9399 11.76 17.9399 11.35V8.82C17.9399 6.47 16.5599 4.44 14.5699 3.49C14.0499 2.57 13.0899 2 11.9899 2C10.8999 2 9.91994 2.59 9.39994 3.52C7.44994 4.49 6.09994 6.5 6.09994 8.82V11.35C6.09994 11.76 5.90994 12.46 5.69994 12.82L4.68994 14.49C4.28994 15.16 4.19994 15.9 4.44994 16.58C4.68994 17.25 5.25994 17.77 5.99994 18.02C7.93994 18.68 9.97994 19 12.0199 19C14.0599 19 16.0999 18.68 18.0399 18.03C18.7399 17.8 19.2799 17.27 19.5399 16.58C19.7999 15.89 19.7299 15.13 19.3399 14.49Z"
                                            fill="#EF4444"></path>
                                        <path
                                            d="M14.8297 20.01C14.4097 21.17 13.2997 22 11.9997 22C11.2097 22 10.4297 21.68 9.87969 21.11C9.55969 20.81 9.31969 20.41 9.17969 20C9.30969 20.02 9.43969 20.03 9.57969 20.05C9.80969 20.08 10.0497 20.11 10.2897 20.13C10.8597 20.18 11.4397 20.21 12.0197 20.21C12.5897 20.21 13.1597 20.18 13.7197 20.13C13.9297 20.11 14.1397 20.1 14.3397 20.07C14.4997 20.05 14.6597 20.03 14.8297 20.01Z"
                                            fill="#EF4444"></path>
                                    </g>
                                </svg>
                            </div>

                        @endif
                        <span class="p-2 rounded-full
                        bg-indigo-500 shadow-indigo-200
                        text-white shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </span>
                        <p class="text-xl font-medium text-slate-700 mt-3">
                            {{ substr(\App\Models\User::whereId($game[0]->opponent_id)->first()->username, 0, 9) }}
                        </p>
                        <p class="mt-2 text-sm text-slate-500">
                            {{ $game[0]->word->name }}
                        </p>
                        <p class="text-sm text-gray-600">{{ $game[0]->created_at->diffForHumans(\Carbon\Carbon::now()) }}</p>
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
