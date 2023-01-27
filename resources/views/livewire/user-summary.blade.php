<div class="flex justify-center mt-6">
    <div
        class="min-w-screen bg-gray-100 flex items-center justify-center border border-gray-300 bg-gray-100 font-sans overflow-hidden">
        <div class="w-full lg:w-5/6">
            <div class="bg-white shadow-md rounded my-6">
                <div class="p-4">
                    <h2 class="text-2xl font-bold tracking-tight sm:text-center sm:text-4xl text-indigo-500">
                        {{ $user->username }}</h2>
                    <h2 class="text-2xl font-bold tracking-tight sm:text-center sm:text-4xl text-red-500">
                        {{ $user->point->point }} puan</h2></div>
                <table class="min-w-max w-full table-auto">
                    <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">Rakip</th>
                        <th class="py-3 px-6 text-left">Kelime</th>
                        <th class="py-3 px-6 text-center">Tahmin Sayısı</th>
                        <th class="py-3 px-6 text-center">Sonuç</th>
                        <th class="py-3 px-6 text-center">Puan</th>
                    </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                    @foreach($games as $game)
                        @if($game->winner_id != null)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="mr-2">
                                        </div>
                                        <span class="font-medium">{{ $game->user->username }}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="mr-2">
                                        </div>
                                        <span class="font-medium">{{ $game->word->name }}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="mr-2">
                                        </div>
                                        <span class="font-medium">{{ $game->guesses->count() }}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="mr-2">
                                        </div>
                                        @if($game->winner_id == $user->id)
                                            <span
                                                class="bg-green-200 text-green-600 py-1 px-3 rounded-full text-xs">Kazandı</span>
                                        @else
                                            <span
                                                class="bg-red-200 text-red-600 py-1 px-3 rounded-full text-xs">Kaybetti</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="mr-2">
                                        </div>
                                        @if($game->winner_id == $user->id)
                                            <span class="font-medium">{{ $game->degree }}</span>
                                        @else
                                            <span class="font-medium">0</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>


