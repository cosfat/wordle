<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-wrap justify-center">
            @foreach($games as $game)
                <div
                    class="p-10 flex flex-col items-center text-center group hover:bg-slate-50 cursor-pointer">
                <span
                    class="p-5 rounded-full @if($game->winner_id != null) bg-gray-500 @else bg-red-500 @endif text-white shadow-lg @if($game->winner_id != null) shadow-gray-200 @else shadow-red-200 @endif"><svg
                        xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg></span>
                    <p class="text-xl font-medium text-slate-700 mt-3">{{ \App\Models\User::find($game->opponent_id)->name}}</p>
                    <p class="mt-2 text-sm text-slate-500">{{ $game->word->name }}</p>
                </div>

            @endforeach

        </div>
    </div>
</div>
</div>
