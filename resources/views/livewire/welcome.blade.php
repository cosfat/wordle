@auth
    <div>
        <div class="max-w-7xl mx-auto">
            <div class="overflow-hidden shadow-xl">
                <div
                    class="bg-indigo-600 shadow-xl shadow-indigo-200 py-10 px-20 flex justify-between items-center">
                    <a href="/"><p class=" text-white"><span class="text-4xl font-medium">WORDLE</span> <br> <span
                                class="text-lg">Rakiplerinle Wordle Oyna! </span></p></a>
                    <button wire:click="$toggle('showCreate')"
                            class="px-5 py-3  font-medium text-slate-700 shadow-xl hover:bg-white duration-150 bg-yellow-400">
                        YENİ OYUN
                    </button>
                    <button wire:click="$toggle('showMyGames')"
                            class="px-5 py-3  font-medium text-slate-700 shadow-xl hover:bg-white duration-150 bg-yellow-400">
                        OYUNLARIM
                    </button>
                    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                        <button
                            class="px-5 py-3  font-medium text-slate-700 shadow-xl  hover:bg-white duration-150  bg-yellow-400">
                            <img class="h-8 w-8 rounded-full object-cover"
                                 src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}"/>
                        </button>
                    @else

                        <button type="button" wire:click="$toggle('showMyProfile')"
                                class="px-5 py-3  font-medium text-slate-700 shadow-xl  hover:bg-white duration-150  bg-yellow-400">
                            {{ Auth::user()->name }}
                        </button>
                    @endif
                </div>
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
                    alert("Yeni oyun!")
                });
        </script>
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
