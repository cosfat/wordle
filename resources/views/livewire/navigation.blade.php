<div>
    <div class="max-w-7xl mx-auto">
        <div class="overflow-hidden shadow-xl">
            <div
                class="bg-indigo-600 shadow-xl shadow-indigo-200 py-10 px-20 flex justify-between items-center">
                <a href="/"><p class=" text-white"><span class="text-4xl font-medium">WORDLE</span> <br> <span
                            class="text-lg">Rakiplerinle Wordle Oyna! </span></p></a>
                <button
                    class="px-5 py-3  font-medium text-slate-700 shadow-xl hover:bg-white duration-150 bg-yellow-400">
                    YENİ OYUN
                </button>
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <button
                        class="px-5 py-3  font-medium text-slate-700 shadow-xl  hover:bg-white duration-150  bg-yellow-400">
                        <img class="h-8 w-8 rounded-full object-cover"
                             src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}"/>
                    </button>
                @else

                    <button type="button"
                            class="px-5 py-3  font-medium text-slate-700 shadow-xl  hover:bg-white duration-150  bg-yellow-400">
                        <a href="{{ route('profile.show') }}">{{ Auth::user()->name }}</a>
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
