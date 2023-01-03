<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 flex justify-center items-center">
                @foreach($games as $game)
                    {{ \App\Models\User::find($game->opponent_id)->name}}<br>
                    {{ $game->word->name }}
                    <hr>
                @endforeach
            </div>
        </div>
    </div>
</div>
