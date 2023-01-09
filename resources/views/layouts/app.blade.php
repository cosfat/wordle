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
            function notifyGame(message) {
                // Get the snackbar DIV
                var x = document.getElementById("notifyBar");

                // Add the "show" class to DIV
                x.className = "show";
                x.textContent = message;

                // After 3 seconds, remove the show class from DIV
                setTimeout(function(){ x.className = x.className.replace("show", ""); }, 4500);
            }

            function notifyIcon(){
                document.getElementById('oyunlarim').classList.add("font-bold");
                document.getElementById('oyunlarim').classList.add("bg-red-500");
                document.getElementById('oyunlarim').classList.add("text-white");
            }

            window.Echo.private(`game-channel.{{ \Illuminate\Support\Facades\Auth::id() }}`)
                .listen('GameNotification', (e) => {
                    notifyGame(`Yeni oyun isteği geldi!`)
                    notifyIcon();
                });
        </script>
        <div id="notifyBar"></div>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

        @livewireScripts
    </body>
</html>
