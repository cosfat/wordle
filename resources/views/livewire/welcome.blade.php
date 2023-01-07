@auth
    <div class="max-w-7xl mx-auto">
        <div>
            <div class="overflow-hidden shadow-xl">
                <div
                    class="bg-indigo-600 py-10 shadow-xl shadow-indigo-200 flex justify-center items-center">

                    <a href="/" class="px-2 py-3 text-indigo-500 font-medium text-slate-700 shadow-xl hover:bg-gray-100 duration-150 bg-white">
                        WORDLE
                    </a>
                    <button wire:click="showCreate"
                            class="px-2 py-3  font-medium text-slate-700 shadow-xl hover:bg-white duration-150 bg-yellow-400 @if($createColor)border-b-2 border-gray-800 @endif">
                        BAŞLA
                    </button>
                    <button wire:click="showMyGames"
                            class="px-2 py-3  font-medium text-slate-700 shadow-xl hover:bg-white duration-150 bg-yellow-400 @if($myGamesColor)border-b-2 border-gray-800 @endif">
                        OYUNLAR
                        <div class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full -top-2 -right-2 dark:border-gray-900">1</div>
                    </button>
                    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                        <button
                            class="px-2 py-3  font-medium text-slate-700 shadow-xl  hover:bg-white duration-150  bg-yellow-400 @if($myProfileColor)border-b-2 border-gray-800 @endif">
                            <img class="h-8 w-8 rounded-full object-cover"
                                 src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}"/>
                        </button>
                    @else

                        <button type="button" wire:click="showMyProfile"
                                class="px-2 py-3  font-medium text-slate-700 shadow-xl  hover:bg-white duration-150  bg-yellow-400 @if($myProfileColor)border-b-2 border-gray-800 @endif">
                            {{ Auth::user()->name }}
                        </button>
                    @endif
                </div>
            </div>
        @if($showCreate)
        <livewire:create-game />
        @endif
        @if($showMyGames)
        <livewire:my-games/>
        @endif
        @if($showMyProfile)
            <livewire:my-profile/>
        @endif
        <script type="module">
            window.Echo.private(`game-channel.{{ \Illuminate\Support\Facades\Auth::id() }}`)
                .listen('GameNotification', (e) => {
                    notifyGame(`Yeni oyun isteği geldi!`)
                    notifyIcon();
                });
        </script>
        </div>
    </div>
@else
    <div>
        <x-guest-layout>
            <x-jet-authentication-card>
                <x-slot name="logo">
                    <x-jet-authentication-card-logo/>
                </x-slot>

                <x-jet-validation-errors class="mb-4"/>

                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div>
                        <x-jet-label for="email" value="{{ __('Email') }}"/>
                        <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email"
                                     :value="old('email')"
                                     required autofocus/>
                    </div>

                    <div class="mt-4">
                        <x-jet-label for="password" value="{{ __('Password') }}"/>
                        <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required
                                     autocomplete="current-password"/>
                    </div>

                    <div class="block mt-4">
                        <label for="remember_me" class="flex items-center">
                            <x-jet-checkbox id="remember_me" name="remember"/>
                            <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 hover:text-gray-900"
                               href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif
                        <x-jet-button class="ml-4">
                            {{ __('Log in') }}
                        </x-jet-button>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('register') }}">
                            {{ __('Register') }}
                        </a>
                    </div>
                </form>
            </x-jet-authentication-card>
        </x-guest-layout>
    </div>
@endauth
