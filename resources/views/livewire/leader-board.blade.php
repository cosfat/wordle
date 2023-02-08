<div class="p-5 border-b-2 container mx-auto">
    @include('loading')
    <div class="p-6 rounded-lg shadow-md p-4 dark:bg-gray-900 dark:border-gray-600 dark:text-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold leading-none text-gray-900 dark:text-white">Skor tablosu (her hafta yenilenir)</h3>
        </div>

        <div class="flex justify-between items-center mb-2">
            <h3 class="text-xl leading-none text-gray-900 dark:text-white">Arkadaşlarım</h3>
        </div>
        <div class="flow-root">
            <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($friends as $friend)
                    <a href="/user-summary/{{ $friend->user->id }}">
                    <li class="py-3 sm:py-2">
                        <div class="flex items-center space-x-4">

                            <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
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
                                <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                    {{ $friend->user->name }}
                                </p>
                            </div>
                            <div
                                class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                {{ $friend->user->point->point}}
                            </div>
                        </div>
                    </li>
                    </a>
                @endforeach
            </ul>
        </div>
        <div class="flex justify-between items-center mb-2 mt-4">
            <h3 class="text-xl leading-none text-gray-900 dark:text-white">Herkes</h3>
        </div>
        <div class="flow-root">
            <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($all as $friend)
                    <a href="/user-summary/{{ $friend->user->id }}">
                        <li class="py-3 sm:py-2">
                            <div class="flex items-center space-x-4">

                                <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
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
                                    <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                        {{ $friend->user->name }}
                                    </p>
                                </div>
                                <div
                                    class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
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