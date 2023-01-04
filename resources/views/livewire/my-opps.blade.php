<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-wrap justify-center">

        @foreach($myOpps as $myOpp)
            <div class="p-10 flex flex-col items-center text-center group     hover:bg-slate-50 cursor-pointer">
                <span class="p-5 rounded-full @if($myOpp->winner_id != null) bg-gray-200 @else bg-indigo-500 @endif text-white shadow-lg @if($myOpp->winner_id != null) shadow-gray-200 @else shadow-indigo-200 @endif"><svg
                        xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg></span>
                <p class="text-xl font-medium text-slate-700 mt-3">{{ $myOpp->user->name}}</p>
                <p class="mt-2 text-sm text-slate-500">{{ $myOpp->word->name }}
                </p>
            </div>
        @endforeach

    </div>


</div>
