<div class="flex justify-center">
    @include('loading')
    <div class="bg-white shadow-md rounded my-6 p-4">
        <div class="p-4">
            <a href="/user-summary/{{ $user->id }}">
                <h2 class="text-2xl font-bold tracking-tight text-center sm:text-4xl text-indigo-500">
                    {{ $user->username }}</h2>
                <h2 class="text-2xl font-bold tracking-tight text-center sm:text-4xl text-red-500">
                    @if($user->point != null)
                        {{ $user->point->point }} puan
                    @endif</h2></a>

            <h2 class="text-2xl font-bold tracking-tight text-center sm:text-4xl text-red-500">
                % {{ $ratio }} başarı</h2>
            <div class="flex justify-center">
                @if(\Illuminate\Support\Facades\Cache::has('user-is-online-' . $user->id))
                    <span class="mt-2 ml-2" style="background-color: chartreuse; height: 25px;
  width: 25px;
  border-radius: 50%;
  display: inline-block;">&nbsp;</span>
                @else
                    <span class="mt-2 ml-2" style="background-color: #494949 ; height: 25px;
  width: 25px;
  border-radius: 50%;
  display: inline-block;">&nbsp;</span>
                @endif
            </div>
        </div>
        <table class="min-w-max w-full table-auto">
            <thead>
            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <th class="py-3 pl-3 text-left">Rakip</th>
                <th class="py-3">Tür</th>
                <th class="py-3">Kelime</th>
                <th class="py-3">Tahmin</th>
                <th class="py-3">Sonuç</th>
                <th class="py-3">Puan</th>
                <th class="py-3 pr-4 pl-3">Oluşturulma</th>
            </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
            @if($games)
            @foreach($games as $game)
                @if($game->winner_id != null)
                    <tr class="border-b border-gray-200 @if($game->usercount) bg-yellow-300 @endif hover:bg-gray-100">
                        <td class="py-3  text-center whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="mr-2">
                                </div>
                                <a href="/user-summary/{{ $game->user->id }}">
                                    <span class="font-medium">{{ $game->user->username }}</span></a>
                            </div>
                        </td>
                        <td class="py-3  text-center whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="mr-2">
                                </div>
                                @if($game->usercount)
                                    <span class="font-medium">Rekabet</span>
                                @else
                                    <span class="font-medium">Klasik</span>
                                @endif
                            </div>
                        </td>
                        <td class="py-3  text-center whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="mr-2">
                                </div>
                                @if($game->usercount)
                                    <a href="/finished-challenge-game-watcher/{{ $game->id }}">
                                        @else
                                            <a href="/finished-game-watcher/{{ $game->id }}">
                                                @endif
                                                <span class="font-medium">{{ $game->word->name }}</span></a>
                            </div>
                        </td>
                        <td class="py-3  text-center whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="mr-2">
                                </div>
                                <span class="font-medium">{{ $game->guesscount }}</span>
                            </div>
                        </td>
                        <td class="py-3  text-center whitespace-nowrap">
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
                        <td class="py-3 text-center whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="mr-2">
                                </div>
                                @if($game->winner_id == $user->id)
                                    @if($game->usercount)
                                    <span class="font-medium">{{ $game->point }}</span>
                                    @else
                                        <span class="font-medium">{{ $game->degree }}</span>
                                    @endif
                                @else
                                    <span class="font-medium">0</span>
                                @endif
                            </div>
                        </td>
                        <td class="py-3 text-center whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="mr-2">
                                </div>
                                <span class="font-medium">{{ $game->created_at->diffForHumans() }}</span>
                            </div>
                        </td>
                    </tr>
                @endif
            @endforeach
            @else
            Hiç oyun yok
            @endif
            </tbody>
        </table>
    </div>
</div>

