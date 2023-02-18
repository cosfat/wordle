<div>
    <div class="flex justify-center">
        <h2 class="text-2xl font-bold tracking-tight sm:text-center sm:text-4xl text-indigo-500">
            SKOR TABLOSU</h2>
    </div>
    <div class="flex justify-center">
        <span class="text-sm">Her pazartesi sıfırlanır</span>
    </div>
    @include('loading')
    <div class="p-6 rounded-lg shadow-md p-4">
        <div class="flex justify-between items-center mb-2">
            <h3 class="text-xl leading-none text-gray-900 ">Arkadaşlarım</h3>
        </div>
        <div class="flow-root">
            <ul role="list" class="divide-y divide-gray-200">
                @foreach($friends as $friend)
                    <a href="/user-summary/{{ $friend->user_id }}">
                        <li class="py-3 sm:py-2">
                            <div class="flex items-center space-x-4">

                                <div class="inline-flex items-center text-base font-semibold text-gray-900 ">
                                    @if(\Illuminate\Support\Facades\Cache::has('user-is-online-' . $friend->user_id))
                                        <span style="background-color: chartreuse; height: 25px;
  width: 25px;
  border-radius: 50%;
  display: inline-block;">&nbsp;</span>
                                    @else
                                        <span style="background-color: #494949 ; height: 25px;
  width: 25px;
  border-radius: 50%;
  display: inline-block;">&nbsp;</span>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate ">
                                        {{ \App\Models\User::find($friend->user_id)->username}}
                                    </p>
                                </div>
                                <div
                                    class="inline-flex items-center text-base font-semibold text-gray-900 ">
                                    {{ $friend->point}}
                                </div>
                            </div>
                        </li>
                    </a>
                @endforeach
            </ul>
        </div>
        <div class="flex justify-between items-center mb-2 mt-4">
            <h3 class="text-xl leading-none text-gray-900 ">Herkes</h3>
        </div>
        <div class="flow-root">
            <ul role="list" class="divide-y divide-gray-200">
                @foreach($all as $friend)
                    <a href="/user-summary/{{ $friend->user->id }}">
                        <li class="py-3 sm:py-2">
                            <div class="flex items-center space-x-4">

                                <div class="inline-flex items-center text-base font-semibold text-gray-900 ">
                                    @if(\Illuminate\Support\Facades\Cache::has('user-is-online-' . $friend->user->id))
                                        <span style="background-color: chartreuse; height: 25px;
  width: 25px;
  border-radius: 50%;
  display: inline-block;">&nbsp;</span>
                                    @else
                                        <span style="background-color: #494949 ; height: 25px;
  width: 25px;
  border-radius: 50%;
  display: inline-block;">&nbsp;</span>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate ">
                                        {{ $friend->user->name }}
                                    </p>
                                </div>
                                <div
                                    class="inline-flex items-center text-base font-semibold text-gray-900 ">
                                    {{ $friend->user->point->point}}
                                </div>
                            </div>
                        </li>
                    </a>
                @endforeach
            </ul>
        </div>
    </div>
</div>
