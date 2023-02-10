<div class="gap-2 container mx-auto rounded-lg">
    <div class="flex justify-center">
        <h2 class="text-2xl font-bold tracking-tight sm:text-center sm:text-4xl text-indigo-500">
            DEVAM EDEN OYUNLAR</h2>
    </div>
    @include('loading')
    <div class="p-5 gap-2 border-b-2">   <div class="flex flex-wrap">
            <h2 class="text-2xl font-bold tracking-tight sm:text-center sm:text-4xl text-indigo-500">
                Günün kelimesi</h2>
        </div>
        @if($fastName != null)
        <div class="flex flex-wrap">
            <p>En hızlı çözen: {{ $fastName }} : {{ $fastValue }} sn</p>
        </div>
        @endif
        @if($shortName != null)
        <div class="flex flex-wrap">
            <p>En az tahminde çözen: {{ $shortName }} : {{ $shortValue }} tahmin</p>
        </div>
        @endif

        <div class="flex flex-wrap">
            @if($today == 0)
                <p>Günün yeni kelimesi geldi!</p>
            @elseif($today == 2)
                <p>Günün kelimesini doğru tahmin ettin!</p>
            @elseif($today == 3)
                <p>Günün kelimesini bilemedin :( Yarın yine gel.</p>
            @elseif($today == 1)
                <p>Günün kelimesini çözmeye devam et!</p>
            @endif
        </div>
        <div class="flex flex-wrap">
            <div style="width: 33%">
                @if($today == 2 OR $today == 3)
                <a href="/finished-game-watcher/{{ $todayGame->id }}">
                    @else
                        <a href="/the-game/{{ $todayGame->id }}">
                    @endif
                    @if($todayGame->chats()->where('user_id', '!=', \Illuminate\Support\Facades\Auth::id())->where('seen', 0)->exists())
                        <div
                            class="absolute mr-12 inline-flex items-center justify-center">
                            <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg" stroke="#EF4444">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path opacity="0.4" d="M8.5 10.5H15.5" stroke="#EF4444" stroke-width="1.5"
                                          stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path
                                        d="M7 18.4302H11L15.45 21.3902C16.11 21.8302 17 21.3602 17 20.5602V18.4302C20 18.4302 22 16.4302 22 13.4302V7.43018C22 4.43018 20 2.43018 17 2.43018H7C4 2.43018 2 4.43018 2 7.43018V13.4302C2 16.4302 4 18.4302 7 18.4302Z"
                                        stroke="#EF4444" stroke-width="1.5" stroke-miterlimit="10"
                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                </g>
                            </svg>
                        </div>
                    @endif
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
                            {{ \App\Models\User::whereId($todayGame->user_id)->first()->username }}
                        </p>
                        <p class="text-sm text-gray-600">{{ $todayGame->created_at->diffForHumans(\Carbon\Carbon::now()) }}</p>
                    </div>
                </a>
            </div>
        </div></div>
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
                    <div style="width: 33%">
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
                    </div>
            @endforeach
            @foreach($new as $game)
                    <div style="width: 33%">
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
                                {{ $game->user->name }}
                            </strong>
                        </p>
                        <p class="text-sm text-gray-600">{{ $game->created_at->diffForHumans(\Carbon\Carbon::now()) }}</p>
                    </div>
                </a>
                    </div>
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

                    <div style="width: 33%">
                @if(\App\Models\Chguess::where('challenge_id', $game->challenge_id)->where('user_id', \Illuminate\Support\Facades\Auth::id())->count() == $game->challenge->length + 1)
                    <a href="/finished-challenge-game-watcher/{{ $game->challenge_id }}">
                        @else
                            <a href="/the-challenge-game/{{ $game->challenge_id }}">
                                @endif
                                <div
                                    class="p-4 flex flex-col  items-center text-center group hover:bg-slate-50 cursor-pointer">
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

                    </div>
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
                    <div style="width: 33%">
                <a href="/the-game/{{ $game[0]->id }}">
                    @if($game[0]->chats()->where('user_id', '!=', \Illuminate\Support\Facades\Auth::id())->where('seen', 0)->exists())
                        <div
                            class="absolute mr-12 inline-flex items-center justify-center">
                            <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg" stroke="#EF4444">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path opacity="0.4" d="M8.5 10.5H15.5" stroke="#EF4444" stroke-width="1.5"
                                          stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path
                                        d="M7 18.4302H11L15.45 21.3902C16.11 21.8302 17 21.3602 17 20.5602V18.4302C20 18.4302 22 16.4302 22 13.4302V7.43018C22 4.43018 20 2.43018 17 2.43018H7C4 2.43018 2 4.43018 2 7.43018V13.4302C2 16.4302 4 18.4302 7 18.4302Z"
                                        stroke="#EF4444" stroke-width="1.5" stroke-miterlimit="10"
                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                </g>
                            </svg>
                        </div>
                    @endif
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
                            {{ \App\Models\User::whereId($game[0]->user_id)->first()->username }}
                        </p>
                        <p class="text-sm text-gray-600">{{ $game[0]->created_at->diffForHumans(\Carbon\Carbon::now()) }}</p>
                    </div>
                </a>
                    </div>
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
                    <div style="width: 33%">
                <a href="/game-watcher/{{ $game[0]->id }}">
                    @if($game[0]->chats()->where('user_id', '!=', \Illuminate\Support\Facades\Auth::id())->where('seen', 0)->exists())
                        <div
                            class="absolute mr-12 inline-flex items-center justify-center">
                            <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg" stroke="#EF4444">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path opacity="0.4" d="M8.5 10.5H15.5" stroke="#EF4444" stroke-width="1.5"
                                          stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path
                                        d="M7 18.4302H11L15.45 21.3902C16.11 21.8302 17 21.3602 17 20.5602V18.4302C20 18.4302 22 16.4302 22 13.4302V7.43018C22 4.43018 20 2.43018 17 2.43018H7C4 2.43018 2 4.43018 2 7.43018V13.4302C2 16.4302 4 18.4302 7 18.4302Z"
                                        stroke="#EF4444" stroke-width="1.5" stroke-miterlimit="10"
                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                </g>
                            </svg>
                        </div>
                    @endif
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
                            {{ \App\Models\User::whereId($game[0]->opponent_id)->first()->username }}
                        </p>
                        <p class="mt-2 text-sm text-slate-500">
                            {{ $game[0]->word->name }}
                        </p>
                        <p class="text-sm text-gray-600">{{ $game[0]->created_at->diffForHumans(\Carbon\Carbon::now()) }}</p>
                    </div>
                </a>
                    </div>
            @endforeach
        </div>
    </div>

</div>

@if (session()->has('message'))
    <script>
        notifyGame("{{  session('message')  }}")
    </script>
@endif
