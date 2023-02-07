<div class="p-5 gap-2 container mx-auto rounded-lg">
    @include('loading')

    <div class="flex justify-center ">
        <button
            class="px-3 py-3 font-medium text-slate-700 shadow-xl @if($mode == 1) bg-white @else bg-yellow-400 @endif hover:bg-white bg- duration-150"
            type="button" wire:click="$set('mode', 1)">
            Rekabet
        </button>
        <button
            class="px-3 py-3 font-medium text-slate-700 shadow-xl @if($mode == 2) bg-white @else bg-yellow-400 @endif hover:bg-white bg- duration-150"
            type="button" wire:click="$set('mode', 2)">
            Gönderdiklerim
        </button>
        <button
            class="px-3 py-3 font-medium text-slate-700 shadow-xl @if($mode == 3) bg-white @else bg-yellow-400 @endif hover:bg-white bg- duration-150"
            type="button" wire:click="$set('mode', 3)">
            Bana sorulanlar
        </button>
    </div>
    <div>
        @if($mode == 1)
            <ul class="text-sm font-medium bg-white text-white rounded-lg">
                @foreach($notesCh as $note)
                    <a href="/finished-challenge-game-watcher/{{ $note['link'] }}">
                        <li class="w-full px-4 py-2 bg-gray-200 text-gray-600"><strong>{{ $note['user'] }}</strong>
                        @if($note['status'] == 1)
                                <strong>{{ $note['word'] }}</strong>
                                <span class="bg-red-600 text-white text-xs font-medium px-2 py-1 rounded">{{ $note['duration'] }}</span>
                                <span class="bg-green-600 text-white text-xs font-medium mr-2 px-2 py-1 rounded">{{ $note['point'] }} p</span>
                        @elseif($note['status']==2)
                                <strong>{{ $note['word'] }}</strong>
                                <span class="bg-red-600 text-white text-xs font-medium px-2 py-1 rounded">{{ $note['duration'] }}</span>
                                <span class="bg-green-600 text-white text-xs font-medium mr-2 px-2 py-1 rounded">{{ $note['point'] }} p</span>
                        @else
                            <li class="w-full px-4 py-2 text-white-500 bg-gray-800">{{ $note['user'] }}:
                                <strong>{{ $note['word'] }}</strong>
                        @endif

                            @if($note['chat'])
                                    <svg class="float-right" width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                                         xmlns="http://www.w3.org/2000/svg" stroke="#EF4444">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path opacity="0.4" d="M8.5 10.5H15.5" stroke="#faccc15" stroke-width="1.5"
                                                  stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path
                                                d="M7 18.4302H11L15.45 21.3902C16.11 21.8302 17 21.3602 17 20.5602V18.4302C20 18.4302 22 16.4302 22 13.4302V7.43018C22 4.43018 20 2.43018 17 2.43018H7C4 2.43018 2 4.43018 2 7.43018V13.4302C2 16.4302 4 18.4302 7 18.4302Z"
                                                stroke="#facc15" stroke-width="1.5" stroke-miterlimit="10"
                                                stroke-linecap="round" stroke-linejoin="round"></path>
                                        </g>
                                    </svg>
                        @endif
                            </li>
                    </a>
                @endforeach
            </ul>
        @elseif($mode == 2)
            <ul class="text-sm font-medium bg-white text-white rounded-lg">
                @foreach($notes as $note)
                    <a href="/finished-game-watcher/{{ $note['link'] }}">
                        <li class="w-full px-4 py-2 text-gray-600 bg-gray-200">{{ $note['user'] }}
                        @if($note['status'] == 1)
                                <strong>{{ $note['word'] }}</strong>
                                <span class="bg-red-600 text-white text-xs font-medium mr-2 px-2 py-1 rounded">{{ $note['duration'] }}</span>
                                <span class="bg-yellow-400 text-indigo-700 text-xs font-medium mr-2 px-2 py-1 rounded"><strong>{{ $note['count'] }}</strong> tahmin</span>
                        @else
                            {{ $note['user'] }}
                                <strong>{{ $note['word'] }}</strong>
                                <span class="bg-red-600 text-white text-xs font-medium mr-2 px-2 py-1 rounded">{{ $note['duration'] }}</span>
                        @endif
                                @if($note['status'] == 1)
                                <span class="bg-green-600 text-white text-xs font-medium mr-2 px-2 py-1 rounded">{{ $note['point'] }} p</span>
                                @else
                                    <span class="bg-gray-800 text-white text-xs font-medium mr-2 px-2 py-1 rounded">Kaybetti</span>
                                @endif
                                @if($note['chat'])
                                    <svg class="float-right" width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                                         xmlns="http://www.w3.org/2000/svg" stroke="#EF4444">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path opacity="0.4" d="M8.5 10.5H15.5" stroke="#facc15" stroke-width="1.5"
                                                  stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path
                                                d="M7 18.4302H11L15.45 21.3902C16.11 21.8302 17 21.3602 17 20.5602V18.4302C20 18.4302 22 16.4302 22 13.4302V7.43018C22 4.43018 20 2.43018 17 2.43018H7C4 2.43018 2 4.43018 2 7.43018V13.4302C2 16.4302 4 18.4302 7 18.4302Z"
                                                stroke="#facc15" stroke-width="1.5" stroke-miterlimit="10"
                                                stroke-linecap="round" stroke-linejoin="round"></path>
                                        </g>
                                    </svg>
                                @endif
                            </li>
                    </a>
                @endforeach
            </ul>
        @else
            <ul class="text-sm font-medium bg-white text-white rounded-lg">
                @foreach($notesMe as $note)
                    <a href="/finished-game-watcher/{{ $note['link'] }}">
                        <li class="w-full px-4 py-2 text-gray-600 bg-gray-200">{{ $note['user'] }}:
                        @if($note['status'] == 1)
                                <strong>{{ $note['word'] }}</strong>
                                <span class="bg-red-600 text-white text-xs font-medium mr-2 px-2 py-1 rounded">{{ $note['duration'] }}</span>
                                <span class="bg-yellow-400 text-indigo-700 text-xs font-medium mr-2 px-2 py-1 rounded"><strong>{{ $note['count'] }}</strong> tahmin</span>
                                <span class="bg-green-600 text-white text-xs font-medium mr-2 px-2 py-1 rounded">{{ $note['point'] }} p</span>
                        @else
                                <strong>{{ $note['word'] }}</strong>
                                <span class="bg-gray-800 text-white text-xs font-medium mr-2 px-2 py-1 rounded">Bilemedin</span>
                        @endif
                                @if($note['chat'])
                                    <svg class="float-right" width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                                         xmlns="http://www.w3.org/2000/svg" stroke="#EF4444">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path opacity="0.4" d="M8.5 10.5H15.5" stroke="#facc15" stroke-width="1.5"
                                                  stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path
                                                d="M7 18.4302H11L15.45 21.3902C16.11 21.8302 17 21.3602 17 20.5602V18.4302C20 18.4302 22 16.4302 22 13.4302V7.43018C22 4.43018 20 2.43018 17 2.43018H7C4 2.43018 2 4.43018 2 7.43018V13.4302C2 16.4302 4 18.4302 7 18.4302Z"
                                                stroke="#facc15" stroke-width="1.5" stroke-miterlimit="10"
                                                stroke-linecap="round" stroke-linejoin="round"></path>
                                        </g>
                                    </svg>
                                @endif
                            </li>
                    </a>
                @endforeach
            </ul>
        @endif
    </div>
</div>
