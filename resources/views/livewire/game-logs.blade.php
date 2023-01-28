<div class="p-5 gap-2 container mx-auto rounded-lg">
    <div>
        <h2>Sizin sorduklarınız</h2>
        <ul class="text-sm font-medium bg-white text-white rounded-lg">
            @foreach($notes as $note)
                <a href="/game-watcher/{{ $note['link'] }}">
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
        <h2 class="mt-3">Size sorulanlar</h2>
        <ul class="text-sm font-medium bg-white text-white rounded-lg">
            @foreach($notesMe as $note)
                <a href="/finished-game-watcher/{{ $note['link'] }}">
                    @if($note['status'] == 1)
                        <li class="w-full px-4 py-2 text-white-500 bg-indigo-500">{{ $note['user'] }} ile
                            <strong>{{ $note['word'] }}</strong> kelimesini
                            <strong>{{ $note['count'] }}</strong> denemede bildiniz
                        </li>
                    @else
                        <li class="w-full px-4 py-2 text-white-500 bg-red-500">{{ $note['user'] }} ile
                            <strong>{{ $note['word'] }}</strong> kelimesini bilemediniz
                        </li>
                    @endif
                </a>
            @endforeach
        </ul>
    </div>
</div>
