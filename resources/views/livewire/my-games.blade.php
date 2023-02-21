<div class="gap-2 container mx-auto rounded-lg">
    <div class="flex justify-center">
        <h2 class="text-2xl font-bold tracking-tight sm:text-center sm:text-4xl text-indigo-500">
            DEVAM EDEN OYUNLAR</h2>
    </div>
    @include('loading')
    <div class="p-5 gap-2 border-b-2">
        <div class="flex flex-wrap">
            <h2 class="text-2xl font-bold tracking-tight sm:text-center sm:text-4xl text-indigo-500">Günün kelimesi</h2>
        </div>
        <div class="flex flex-wrap text-sm">
            Sonraki kelime: <span
                class="ml-2 bg-red-600 text-white text-xs font-medium px-2 py-1 rounded">{{ $diff }}</span>
        </div>
        <div class="flex flex-wrap">
            @if($today == 0)
                <p>Günün yeni kelimesi geldi!</p>
            @elseif($today == 2)
                <p class="text-green-600">Günün kelimesini doğru tahmin ettin!</p>
            @elseif($today == 3)
                <p>Günün kelimesini bilemedin ☹️</p>
            @elseif($today == 1)
                <p>Günün kelimesini çözmeye devam et!</p>
            @endif
        </div>
        @if($fastName != null)
            <div class="flex flex-wrap">
                @if($today == 2 OR $today == 3)
                    <a href="/finished-game-watcher/{{ $fastId }}">
                        @endif
                        <p class="text-red-600">En hızlı çözen: <strong>{{ $fastName }} : {{ $fastValue }}</strong></p>
                    </a>
            </div>
        @endif
        @if($shortName != null)
            <div class="flex flex-wrap">
                @if($today == 2 OR $today == 3)
                    <a href="/finished-game-watcher/{{ $shortId }}">
                        @endif
                        <p class="text-red-600">En az tahminde çözen: <strong>{{ $shortName }} : {{ $shortValue }}
                                tahmin </strong></p>
                    </a>
            </div>
        @endif
        <div class="flex flex-wrap">
            <div style="width: 33%">
                @if($today == 2 OR $today == 3)
                    <a href="/finished-game-watcher/{{ $todayGame->id }}">
                @else
                    <a href="/the-game/{{ $todayGame->id }}">
                @endif
                        <div class="p-4 flex flex-col items-center text-center group hover:bg-slate-50 cursor-pointer">
                            @if($todayGame->seen == 0)
                            <div
                                class="absolute mt-3 inline-flex items-center justify-center p-2 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full">
                                Yeni oyun!
                            </div>
                            @endif
                        <span class="p-2 rounded-full
                        @if($today == 2 OR $today == 3)
                            bg-indigo-500 shadow-indigo-200
                        @else
                            bg-red-500 shadow-red-200
                        @endif
                            text-white shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </span>
                                    <p class="text-xl font-medium text-slate-700 mt-3">
                                        {{ \App\Models\User::whereId($todayGame->user_id)->first()->username }}
                                    </p>
                                    @if($today == 2 OR $today == 3)
                                        <p class="text-sm text-gray-600">{{ $todayGame->word->name }}</p>
                                    @else
                                        <p class="text-sm text-gray-600">{{ $todayGame->created_at->diffForHumans(\Carbon\Carbon::now()) }}</p>
                                    @endif
<div class="flex justify-center">
                                <span class="bg-green-600 text-white text-xs font-medium px-2 py-1 rounded">
                    <svg
                        fill="#FACC14"
                        version="1.1"
                        id="Capa_1"
                        xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink"
                        width="20px"
                        height="20px"
                        viewBox="0 0 145.312 145.311"
                        xml:space="preserve"
                        stroke="#FACC14"><g
                            id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <g>
                                    <path
                                        d="M115.451,132.818c0,1.487-1.207,2.7-2.699,2.7H32.563c-1.492,0-2.7-1.213-2.7-2.7s1.208-2.7,2.7-2.7h80.188 C114.244,130.118,115.451,131.321,115.451,132.818z M145.167,29.627l-31.408,91.626c-0.369,1.092-1.393,1.825-2.553,1.825H34.101 c-1.154,0-2.18-0.733-2.552-1.825L0.146,29.627c-0.253-0.741-0.172-1.55,0.216-2.226c0.391-0.675,1.05-1.149,1.817-1.302 c17.479-3.472,36.215-0.087,50.838,9.034l17.442-24.282c1.015-1.411,3.37-1.411,4.385,0l17.441,24.282 c14.623-9.121,33.37-12.501,50.842-9.034c0.765,0.153,1.429,0.627,1.819,1.302C145.336,28.083,145.421,28.892,145.167,29.627z M46.678,49.082c-6.565-4.485-14.407-7.473-22.667-8.648c-0.936-0.143-1.854,0.227-2.452,0.943 c-0.601,0.718-0.789,1.696-0.493,2.582l13.205,39.7c0.377,1.135,1.429,1.846,2.565,1.846c0.28,0,0.567-0.042,0.852-0.131 c1.416-0.47,2.184-1.999,1.711-3.412L27.644,46.608c5.816,1.355,11.28,3.723,16,6.945c1.226,0.833,2.906,0.524,3.752-0.707 C48.239,51.61,47.909,49.93,46.678,49.082z"></path>
                                </g>
                            </g></svg>
                    {{ $todayWinners }}
                </span>

                                <span class="ml-2 bg-red-600 text-white text-xs font-medium px-2 py-1 rounded">
                        <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"
                             xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                             fill="#FFFFFF">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier"><title>angry</title>
                                <g id="people" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <g id="angry" fill="#FFFFFF">
                                        <path
                                            d="M12,22 C6.4771525,22 2,17.5228475 2,12 C2,6.4771525 6.4771525,2 12,2 C17.5228475,2 22,6.4771525 22,12 C22,17.5228475 17.5228475,22 12,22 Z M12,20 C16.418278,20 20,16.418278 20,12 C20,7.581722 16.418278,4 12,4 C7.581722,4 4,7.581722 4,12 C4,16.418278 7.581722,20 12,20 Z M16,17 L14.6611201,17 C14.6611201,17 14.2442153,14.3333333 12,14.3333333 C9.75578467,14.3333333 9.33333333,17 9.33333333,17 L8,17 C8,14.790861 9.790861,13 12,13 C14.209139,13 16,14.790861 16,17 Z M10.506405,8.98983837 C10.7565765,9.25783918 10.909675,9.61762369 10.909675,10.0131663 C10.909675,10.8415934 10.2381021,11.5131663 9.40967501,11.5131663 C8.58124788,11.5131663 7.90967501,10.8415934 7.90967501,10.0131663 C7.90967501,9.33142915 8.36447289,8.75591575 8.98721669,8.57347804 L7.329126,7.96998239 C7.06963705,7.87553613 6.93584351,7.58861496 7.03028977,7.329126 C7.12473602,7.06963705 7.4116572,6.93584351 7.67114615,7.03028977 L10.490224,8.0563502 C10.749713,8.15079645 10.8835065,8.43771763 10.7890602,8.69720658 C10.7386018,8.83584008 10.6332053,8.93859642 10.506405,8.98983837 Z M13.40327,8.98983837 C13.2764697,8.93859642 13.1710732,8.83584008 13.1206148,8.69720658 C13.0261685,8.43771763 13.159962,8.15079645 13.419451,8.0563502 L16.2385289,7.03028977 C16.4980178,6.93584351 16.784939,7.06963705 16.8793852,7.329126 C16.9738315,7.58861496 16.840038,7.87553613 16.580549,7.96998239 L14.9224583,8.57347804 C15.5452021,8.75591575 16,9.33142915 16,10.0131663 C16,10.8415934 15.3284271,11.5131663 14.5,11.5131663 C13.6715729,11.5131663 13,10.8415934 13,10.0131663 C13,9.61762369 13.1530985,9.25783918 13.40327,8.98983837 Z"
                                            id="Shape"></path>
                                    </g>
                                </g>
                            </g>
                        </svg>
                    {{ $todayLosers }}</span></div>
                        </div>
                    </a>
            </div>
            <div style="width: 66%" class="p-2">
                @if(count($todays) > 0)
                    @php($x = 1)
                    @foreach($todays as $todayUser)
                        @if($today == 2 OR $today == 3)
                            <a href="/finished-game-watcher/{{ $todayUser[0] }}">@endif
                                <span class="text-sm border-b text-indigo-500">{{ $x }} - {{ ucfirst($todayUser[1]) }}: {{ $todayUser[2] }}, {{ $todayUser[3] }} tahmin</span></a>
                            <br>
                            @php($x+=1)
                            @endforeach
                        @endif
            </div>
        </div>
    </div>
    <div class="p-5 gap-2 border-b-2">
        <div class="flex flex-wrap">
            <h2 class="text-2xl font-bold tracking-tight sm:text-center sm:text-4xl text-indigo-500">
                Yeni oyun isteklerim</h2>
        </div>
        <div class="flex flex-wrap">
            @if($new->count() == 0 AND $newChallenges->count() == 0 AND $newDuellos->count() == 0)
                <p>Hiç oyun isteğin yok, oyunu arkadaşlarına tavsiye edebilirsin!</p>
            @endif
                @foreach($newDuellos as $game)
                    <div style="width: 33%">
                        <a href="/the-game/{{ $game->id }}/1">
                            <div class="p-4 flex flex-col  items-center text-center group hover:bg-slate-50 cursor-pointer">
                                <div
                                    class="absolute mt-3 inline-flex items-center justify-center p-2 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full">
                                    Yeni Düello
                                </div>
                                <span class="p-2 rounded-full bg-yellow-400 text-white shadow-lg">
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
                    </div>
                @endforeach
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
                Rekabetler</h2>
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
                Düellolar</h2>
        </div>
        <div class="flex flex-wrap">
            @if($duellos->count() == 0)
                <p>Hiç düellon yok, yeni düello başlatmak için <a href="/create-game">tıkla!</a>
                </p>
            @endif
            @foreach($duellos as $game)
                <div style="width: 33%">
                    <a href="/the-game/{{ $game->id }}/1">
                        @if($game->chats()->where('user_id', '!=', \Illuminate\Support\Facades\Auth::id())->where('seen', 0)->exists())
                            <div
                                class="absolute mr-12 inline-flex items-center justify-center">
                                <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                                     xmlns="http://www.w3.org/2000/svg" stroke="#EF4444">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path opacity="0.4" d="M8.5 10.5H15.5" stroke="#EF4444" stroke-width="1.5"
                                              stroke-miterlimit="10" stroke-linecap="round"
                                              stroke-linejoin="round"></path>
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
                            @if($game->sira == \Illuminate\Support\Facades\Auth::id())
                            <div
                                class="absolute mt-3 inline-flex items-center justify-center p-2 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full">
                                Sıra sende!
                            </div>
                            @endif
                        <span class="p-2 rounded-full
                        bg-yellow-400
                        text-white shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </span>
                            <p class="text-xl font-medium text-slate-700 mt-3">
                                @if($game->user_id == \Illuminate\Support\Facades\Auth::id())
                                    {{ \App\Models\User::whereId($game->opponent_id)->first()->username }}
                                @else
                                    {{ \App\Models\User::whereId($game->user_id)->first()->username }}
                                @endif
                            </p>
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
                Klasik</h2>
        </div>
        <div class="flex flex-wrap">
            @if($gamesOpp->count() == 0)
                <p>Hiç oyunun yok, oyunu arkadaşlarına tavsiye edebilirsin!
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
                                              stroke-miterlimit="10" stroke-linecap="round"
                                              stroke-linejoin="round"></path>
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
                                              stroke-miterlimit="10" stroke-linecap="round"
                                              stroke-linejoin="round"></path>
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
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                           stroke-linejoin="round"></g>
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
