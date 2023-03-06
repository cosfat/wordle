<div class="flex flex-wrap">
    @include('loading')
    <div class="bg-white shadow-md rounded my-6 p-4 w-full">
            <a href="/user-summary/{{ $user->id }}">
            <h2 class="text-2xl font-bold tracking-tight text-center sm:text-4xl text-indigo-500">
                    {{ $user->username }}

                    @if(\Illuminate\Support\Facades\Cache::has('user-is-online-' . $user->id))
                        <span class="bg-green-600 text-white text-xs font-medium px-2 py-1 rounded">online</span>
                    @else
                        <span class="bg-red-600 text-white text-xs font-medium px-2 py-1 rounded">offline</span>
                    @endif
            </h2>
            <h2 class="text-slate-500 text-center">"{{ $level }}"</h2>
            <h2 class="text-2xl font-bold tracking-tight text-center sm:text-4xl text-red-500">
                    @if($user->point != null)
                        {{ $user->point->point }} puan, % {{ $ratio }} başarı
                    @endif</h2></a>
            <div class="flex justify-center">
                <span class="mr-2 bg-green-600 text-white text-xs font-medium px-2 py-1 rounded">
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
                    {{ $winGames }}
                </span>
                <livewire:contact-wire :friend="$user->id"/>
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
                    {{ $lostGames }}</span>
            </div>
    </div>
    <div class="bg-white shadow-md rounded my-2 p-4 w-full flex justify-center">
    <table class="min-w-max table-auto">
        <thead>
        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
            <th class="py-3 pl-3 text-left">Rakip</th>
            <th class="py-3">Tür</th>
            <th class="py-3">Kelime</th>
            <th class="py-3">Sonuç</th>
            <th class="py-3 px-2">Puan</th>
        </tr>
        </thead>
        <tbody class="text-gray-600 text-sm font-light">
        @if($games)
            @foreach($games as $game)
                @if($game->today_id == $todayId)
                @else

                    @if($game->winner_id != null)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3  text-center whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="mr-2">
                                    </div>
                                    @if($game->user->id != 2)
                                        <a href="/user-summary/{{ $game->user->id }}">@endif
                                            @if($game->user->id == 2)
                                                <span
                                                    class="font-medium font-bold text-red-600">{{ $game->user->username }}</span>
                                            @else

                                                <span class="font-medium">{{ $game->user->username }}</span>
                                            @endif
                                        </a>
                                </div>
                            </td>
                            <td class="py-3  text-center whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="mr-2">
                                    </div>
                                    @if($game->usercount)
                                        <a href="/finished-challenge-game-watcher/{{ $game->id }}">
                                        <span class="font-medium"
                                              style="color: #facc15; font-weight: bold">Rekabet</span></a>
                                    @else
                                        @if($game->isduello == 1)
                                            <a href="/finished-game-watcher/{{ $game->id }}">
                                        <span class="font-medium"
                                              style="color: #4F46E5; font-weight: bold">Düello</span>
                                            </a>
                                        @else
                                            <a href="/finished-game-watcher/{{ $game->id }}">
                                        <span class="font-medium"
                                              style="color: #4F46E5; font-weight: bold">Klasik</span>
                                            </a>
                                        @endif
                                    @endif
                                </div>
                            </td>
                            <td class="py-3  text-center whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="mr-2">
                                    </div>
                                    @if($game->usercount)
                                        <a href="/finished-challenge-game-watcher/{{ $game->id }}">
                                            @else
                                                <a href="/finished-game-watcher/{{ $game->id }}">
                                                    @endif
                                                    <span class="font-medium">{{ $game->word->name }}</span>
                                                </a>
                                </div>
                            </td>
                            <td class="py-3  text-center whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="mr-2">
                                    </div>
                                    @if($game->winner_id == $user->id)
                                        <span
                                            class="bg-green-200 text-green-600 py-1 px-3 rounded-full text-xs">Kazandı</span>
                                    @else
                                        <span
                                            class="bg-red-200 text-red-600 py-1 px-3 rounded-full text-xs">Kaybetti</span>
                                    @endif
                                </div>
                            </td>
                            <td class="py-3 text-center whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="mr-2">
                                    </div>
                                    @if($game->winner_id == $user->id)
                                        @if($game->usercount)
                                            <span class="font-medium">{{ $game->point }}</span>
                                        @else
                                            <span class="font-medium">{{ $game->degree }}</span>
                                        @endif
                                    @else
                                        <span class="font-medium">0</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endif
                @endif

            @endforeach
        @else
            Hiç oyun yok
        @endif
        </tbody>
    </table>
    </div>
</div>

