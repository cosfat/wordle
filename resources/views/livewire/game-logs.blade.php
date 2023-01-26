<div class="p-5 gap-2 border-b-2">
    <div>
        <ul class="text-sm font-medium bg-white text-gray-900 border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            @foreach($notes as $note)
                @if($note['status'] == 1)
                <li class="w-full px-4 py-2 text-white-500 bg-indigo-500 border-b border-gray-200 rounded-t-lg">{{ $note['user'] }}
                    <strong>{{ $note['word'] }}</strong> kelimesini
                    <strong>{{ $note['count'] }}</strong> denemede bildi
                </li>
                @else
                    <li class="w-full px-4 py-2 text-white-500 bg-red-500 border-b border-gray-200 rounded-t-lg">{{ $note['user'] }}
                        <strong>{{ $note['word'] }}</strong> kelimesini bilemedi
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</div>
