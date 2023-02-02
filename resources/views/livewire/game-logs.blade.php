<div class="p-5 gap-2 container mx-auto rounded-lg">
    @include('loading')
    <div>
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
                </li>
                @else
                    <li class="w-full px-4 py-2 text-white-500 bg-red-500">{{ $note['user'] }}
                        <strong>{{ $note['word'] }}</strong> kelimesini bilemedi
                    </li>
                @endif
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
                        </li>
                    @else
                        <li class="w-full px-4 py-2 text-white-500 bg-red-500">{{ $note['user'] }} ile
                            <strong>{{ $note['word'] }}</strong> kelimesini bilemedin
                        </li>
                    @endif
                </a>
            @endforeach
        </ul>
            @endif
    </div>
</div>
