<div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-wrap justify-center">
            @foreach($games as $game)
                    <div
                        class="p-10 flex flex-col items-center text-center group hover:bg-slate-50 cursor-pointer" @if($game->user->id != \Illuminate\Support\Facades\Auth::id()) wire:click="theGame({{ $game->id }})" @endif>
                        @if($game->opponent_id == \Illuminate\Support\Facades\Auth::id() AND $game->seen == 0)
                                <div
                                    class="absolute inline-flex items-center justify-center p-2 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full">
                                    Yeni oyun
                                </div>
                            </button>
                        @endif
                        <span
                            class="p-5 rounded-full @if($game->winner_id != null) bg-gray-500 @else
                            @if($game->user->id == \Illuminate\Support\Facades\Auth::id())
                                bg-red-500
                            @else
                                bg-indigo-500
                            @endif
                            @endif text-white shadow-lg @if($game->winner_id != null) shadow-gray-200 @else
                            @if($game->user->id == \Illuminate\Support\Facades\Auth::id())
                                shadow-red-200 @else
                                shadow-indigo-200
                    @endif
                            @endif"><svg
                                xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg></span>

                        <p class="text-xl font-medium text-slate-700 mt-3">
                            @if($game->user_id != \Illuminate\Support\Facades\Auth::id())
                                {{ $game->user->name}}
                            @else
                                {{ \App\Models\User::find($game->opponent_id)->name}}
                            @endif
                        </p>
                        <p class="mt-2 text-sm text-slate-500">
                            @if($game->user_id != \Illuminate\Support\Facades\Auth::id())
                                *****
                            @else
                                {{ $game->word->name }}
                            @endif

                        </p>
                    </div>
            @endforeach
        </div>
        <div class="flex justify-end p-6">{{ $games->links() }}</div>
</div>
