<div class="p-5 gap-2 container mx-auto rounded-lg">
    @include('loading')

    <div class="flex justify-center">
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
            <h2 class="mt-3">Rekabet oyunları</h2>
            <ul class="text-sm font-medium bg-white text-white rounded-lg">
                @foreach($notesCh as $note)
                    <a href="/finished-challenge-game-watcher/{{ $note['link'] }}">
                        @if($note['status'] == 1)
                            <li class="w-full px-4 py-2 text-white-500 bg-red-500">{{ $note['user'] }}
                                <strong>{{ $note['word'] }}</strong> kelimesiyle kazandı
                            </li>
                        @elseif($note['status']==2)
                            <li class="w-full px-4 py-2 text-white-500 bg-indigo-500">
                                <strong>{{ $note['word'] }}</strong> kelimesiyle kazandın
                            </li>
                        @else
                            <li class="w-full px-4 py-2 text-white-500 bg-red-500">{{ $note['user'] }}:
                                <strong>{{ $note['word'] }}</strong>
                            </li>
                        @endif
                    </a>
                @endforeach
            </ul>
        @elseif($mode == 2)
            <h2 class="mt-3">Gönderdiğim oyunlar</h2>
            <ul class="text-sm font-medium bg-white text-white rounded-lg">
                @foreach($notes as $note)
                    <a href="/finished-game-watcher/{{ $note['link'] }}">
                        @if($note['status'] == 1)
                            <li class="w-full px-4 py-2 text-white-500 bg-indigo-500">{{ $note['user'] }}
                                <strong>{{ $note['word'] }}</strong> kelimesini
                                <strong>{{ $note['count'] }}</strong> denemede bildi
                        @else
                            <li class="w-full px-4 py-2 text-white-500 bg-red-500">{{ $note['user'] }}
                                <strong>{{ $note['word'] }}</strong> kelimesini bilemedi
                        @endif
                                @if($note['chat'])
                                    <svg class="float-right" width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                                         xmlns="http://www.w3.org/2000/svg" stroke="#EF4444">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path opacity="0.4" d="M8.5 10.5H15.5" stroke="#ffffff" stroke-width="1.5"
                                                  stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path
                                                d="M7 18.4302H11L15.45 21.3902C16.11 21.8302 17 21.3602 17 20.5602V18.4302C20 18.4302 22 16.4302 22 13.4302V7.43018C22 4.43018 20 2.43018 17 2.43018H7C4 2.43018 2 4.43018 2 7.43018V13.4302C2 16.4302 4 18.4302 7 18.4302Z"
                                                stroke="#ffffff" stroke-width="1.5" stroke-miterlimit="10"
                                                stroke-linecap="round" stroke-linejoin="round"></path>
                                        </g>
                                    </svg>
                                @endif
                            </li>
                    </a>
                @endforeach
            </ul>
        @else
            <h2 class="mt-3">Bana sorulanlar</h2>
            <ul class="text-sm font-medium bg-white text-white rounded-lg">
                @foreach($notesMe as $note)
                    <a href="/finished-game-watcher/{{ $note['link'] }}">
                        @if($note['status'] == 1)
                            <li class="w-full px-4 py-2 text-white-500 bg-indigo-500">{{ $note['user'] }} ile
                                <strong>{{ $note['word'] }}</strong> kelimesini
                                <strong>{{ $note['count'] }}</strong> denemede bildin
                        @else
                            <li class="w-full px-4 py-2 text-white-500 bg-red-500">{{ $note['user'] }} ile
                                <strong>{{ $note['word'] }}</strong> kelimesini bilemedin
                        @endif
                                @if($note['chat'])
                                    <svg class="float-right" width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                                         xmlns="http://www.w3.org/2000/svg" stroke="#EF4444">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path opacity="0.4" d="M8.5 10.5H15.5" stroke="#ffffff" stroke-width="1.5"
                                                  stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path
                                                d="M7 18.4302H11L15.45 21.3902C16.11 21.8302 17 21.3602 17 20.5602V18.4302C20 18.4302 22 16.4302 22 13.4302V7.43018C22 4.43018 20 2.43018 17 2.43018H7C4 2.43018 2 4.43018 2 7.43018V13.4302C2 16.4302 4 18.4302 7 18.4302Z"
                                                stroke="#ffffff" stroke-width="1.5" stroke-miterlimit="10"
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
