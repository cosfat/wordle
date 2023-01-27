<div class="p-5 gap-2 border-b-2">
        <div class="rounded-lg border shadow-md p-4 bg-gray-800 border-gray-700">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold leading-none text-gray-900 dark:text-white">Skor tablosu</h3>
            </div>
            <div class="flow-root">
                <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($friends as $friend)
                        <li class="py-3 sm:py-2">
                            <div class="flex items-center space-x-4">
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
                    @endforeach
                </ul>
            </div>
        </div>
</div>
