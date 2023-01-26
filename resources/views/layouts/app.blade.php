<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/css/custom.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles

        <script type="module">
            window.Echo.private(`game-channel.{{ \Illuminate\Support\Facades\Auth::id() }}`)
                .listen('GameNotification', (e) => {
                    notifyGame("Yeni oyun isteği geldi!", "my-games");
                    notifyIcon();
                });

            window.Echo.private(`guesses-channel.{{ \Illuminate\Support\Facades\Auth::id() }}`)
                .listen('GuessTyped', (e) => {
                    console.log(e)
                    notifyGame("Tahminde bulunuldu!", "my-games");

                    Livewire.emit('refreshLogs');
                    Livewire.emit('refreshFeed');
                    Livewire.emit('refreshGameWatcher');
                });
        </script>
        <script>
            function notifyGame(message, address=null) {
                // Get the snackbar DIV
                var x = document.getElementById("notifyBar");

                // Add the "show" class to DIV
                x.className = "show";

                if(address != null){

                    x.innerHTML = "<a href='/"+address+"'>"+message+"</a>";
                }
                else{

                    x.textContent = message;
                }

                // After 3 seconds, remove the show class from DIV
                setTimeout(function(){ x.className = x.className.replace("show", ""); }, 4500);
            }

            function notifyIcon(){
                document.getElementById('games').classList.add("font-bold");
                document.getElementById('games').classList.add("bg-red-500");
                document.getElementById('games').classList.add("text-white");
            }
        </script>
        <div id="notifyBar"></div>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-100">
            @auth
                <div name="welcome" class="max-w-7xl mx-auto">
                    <div>
                        <div name="menu-bar" class="overflow-hidden shadow-xl">
                            <div class="bg-indigo-600 py-10 shadow-xl shadow-indigo-200 flex justify-center items-center">

                                <a href="/"
                                   class="px-2 py-3 text-indigo-500 font-medium font-bold shadow-xl hover:bg-gray-100 duration-150 bg-white">
                                    WORDLE
                                </a>
                                <a href="/create-game" class="px-2 py-3  font-medium  shadow-xl hover:bg-white duration-150 bg-yellow-400">
                                    BAŞLA
                                </a>
                                <a id="games" href="/my-games" class="cursor-pointer px-2 py-3

                                 @if(\App\Models\Game::where('opponent_id', \Illuminate\Support\Facades\Auth::id())->where('seen', 0)->exists())
                                    font-bold bg-red-500 text-white
                                    @endif

                                 font-medium shadow-xl hover:bg-white hover:text-gray-800 duration-150 bg-yellow-400">
                                    OYUNLAR
                                </a>
                                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                    <button
                                        class="px-2 py-3 font-medium  shadow-xl  hover:bg-white duration-150  bg-yellow-400 @if($myProfileColor)border-b-2 border-gray-800 @endif">
                                        <img class="h-8 w-8 rounded-full object-cover"
                                             src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}"/>
                                    </button>
                                @else

                                    <a href="/my-profile" class="px-2 py-3  font-medium  shadow-xl  hover:bg-white duration-150  bg-yellow-400">
                                        {{ Auth::user()->name }}
                                    </a>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
                <!-- Page Content -->
                <main>
                    {{ $slot }}
                </main>
<div class="flex flex-wrap">
    <livewire:game-logs></livewire:game-logs>
    <livewire:friend-feed></livewire:friend-feed>
</div>
            @else
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
                                <x-jet-label for="username" value="{{ __('Kullanıcı adı') }}"/>
                                <x-jet-input id="username" class="block mt-1 w-full" type="text" name="username"
                                             :value="old('username')"
                                             required autofocus/>
                            </div>
                            <div class="mt-4">
                                <x-jet-label for="password" value="{{ __('Parola') }}"/>
                                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required
                                             autocomplete="current-password"/>
                            </div>

                            <div class="block mt-4">
                                <label for="remember_me" class="flex items-center">
                                    <x-jet-checkbox id="remember_me" name="remember"/>
                                    <span class="ml-2 text-sm text-gray-600">{{ __('Beni hatırla') }}</span>
                                </label>
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                @if (Route::has('password.request'))
                                    <a class="underline text-sm text-gray-600 hover:text-gray-900"
                                       href="{{ route('password.request') }}">
                                        {{ __('Parola hatırlatıcısı') }}
                                    </a>
                                @endif
                                <x-jet-button class="ml-4">
                                    {{ __('Giriş') }}
                                </x-jet-button>
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('register') }}">
                                    {{ __('Üye ol') }}
                                </a>
                            </div>
                        </form>
                    </x-jet-authentication-card>
                </x-guest-layout>
            @endauth
        </div>

        @stack('modals')

        @livewireScripts
    </body>
</html>
