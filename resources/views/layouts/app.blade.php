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
                Livewire.emit('MyGames');
                notifyGame("Yeni oyun isteği geldi!", "my-games");
                notifyIcon();
            });

        window.Echo.private(`guesses-channel.{{ \Illuminate\Support\Facades\Auth::id() }}`)
            .listen('GuessTyped', (e) => {
                console.log(e)
                notifyGame("Tahminde bulunuldu!", "my-games");

                Livewire.emit('refreshLogs');
                Livewire.emit('refreshFeed');
                Livewire.emit('MyGames');
                Livewire.emit('refreshGameWatcher');
            });
    </script>
    <script>
        function notifyGame(message, address = null) {
            // Get the snackbar DIV
            var x = document.getElementById("notifyBar");

            // Add the "show" class to DIV
            x.className = "show";

            if (address != null) {

                x.innerHTML = "<a href='/" + address + "'>" + message + "</a>";
            } else {

                x.textContent = message;
            }

            // After 3 seconds, remove the show class from DIV
            setTimeout(function () {
                x.className = x.className.replace("show", "");
            }, 4500);
        }

        function notifyIcon() {
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
        <div name="welcome" class="mx-auto">
            <div>
                <div class="bg-indigo-600 shadow-xl shadow-indigo-800 flex items-center p-6"
                     style="position:  fixed; bottom: 0; width: 100%; justify-content: space-evenly">

                    <a href="/"
                       class="px-2 py-3 text-indigo-500 font-medium font-bold shadow-xl hover:bg-gray-100 duration-150 bg-white" style="border-radius: 20px">
                        KELİMEO
                    </a>
                    <a href="/create-game">
                        <svg fill="#FACC15" width="64px" height="64px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>plus</title> <path d="M15.5 29.5c-7.18 0-13-5.82-13-13s5.82-13 13-13 13 5.82 13 13-5.82 13-13 13zM21.938 15.938c0-0.552-0.448-1-1-1h-4v-4c0-0.552-0.447-1-1-1h-1c-0.553 0-1 0.448-1 1v4h-4c-0.553 0-1 0.448-1 1v1c0 0.553 0.447 1 1 1h4v4c0 0.553 0.447 1 1 1h1c0.553 0 1-0.447 1-1v-4h4c0.552 0 1-0.447 1-1v-1z"></path> </g></svg>
                    </a>
                    <a href="/my-games">
                    <svg id="games" width="64px" height="64px" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg"
                         @if(\App\Models\Game::where('opponent_id', \Illuminate\Support\Facades\Auth::id())->where('seen', 0)->exists())
                         fill="#FACC15"
                    @else
                             fill="red" stroke="red"
                        @endif
                    ><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M0 0h48v48H0z" fill="none"></path> <g id="Shopicon"> <path d="M24,44c11.046,0,20-8.954,20-20S35.046,4,24,4S4,12.954,4,24S12.954,44,24,44z M24,12c3.309,0,6,2.691,6,6 c0,2.642-1.331,3.938-2.302,4.885C26.712,23.846,26,24.54,26,26.999h-4c0-4.146,1.68-5.783,2.906-6.979 C25.702,19.244,26,18.954,26,18c0-1.103-0.897-2-2-2s-2,0.897-2,2h-4C18,14.691,20.691,12,24,12z M24,36c-1.105,0-2-0.895-2-2 c0-1.105,0.895-2,2-2c1.105,0,2,0.895,2,2C26,35.105,25.105,36,24,36z"></path> </g> </g></svg>

                    </a>
                    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                        <button
                            class="px-2 py-3 font-medium  shadow-xl  hover:bg-white duration-150  bg-yellow-400 @if($myProfileColor)border-b-2 border-gray-800 @endif">
                            <img class="h-8 w-8 rounded-full object-cover"
                                 src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}"/>
                        </button>
                    @else

                        <a href="/my-profile"><svg width="64px" height="64px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="style=fill"> <g id="profile"> <path id="vector (Stroke)" fill-rule="evenodd" clip-rule="evenodd" d="M6.75 6.5C6.75 3.6005 9.1005 1.25 12 1.25C14.8995 1.25 17.25 3.6005 17.25 6.5C17.25 9.3995 14.8995 11.75 12 11.75C9.1005 11.75 6.75 9.3995 6.75 6.5Z" fill="#FACC15"></path> <path id="rec (Stroke)" fill-rule="evenodd" clip-rule="evenodd" d="M4.25 18.5714C4.25 15.6325 6.63249 13.25 9.57143 13.25H14.4286C17.3675 13.25 19.75 15.6325 19.75 18.5714C19.75 20.8792 17.8792 22.75 15.5714 22.75H8.42857C6.12081 22.75 4.25 20.8792 4.25 18.5714Z" fill="#FACC15"></path> </g> </g> </g></svg>
                        </a>
                    @endif
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

                    <div class="flex justify-center">
                        <h2 class="text-2xl font-bold tracking-tight sm:text-center sm:text-4xl text-indigo-500">
                            Yeni Adresimiz kelimeo.com</h2></div>

                    <div class="flex justify-center"><h2>Lütfen mevcut şifrenizle giriş yapın</h2></div>
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
