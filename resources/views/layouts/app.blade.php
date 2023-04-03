<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Kelimeo ile arkadaşlarınla veya tek başına wordle tarzı kelime oyunu oyna"/>
    <meta name="keywords" content="kelimeo, kelime oyunu, wordle, online kelime oyunu, online oyna, kelime oyunu kelimeler, anlat bakalım, bil bakalım, kelime bulmaca"/>
    <meta name="theme-color" content="#facc15">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="/css/fontbunny.css">
    <link rel="manifest" href="/manifest.json">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/css/custom.css', 'resources/js/app.js'])
    <script src="https://js.pusher.com/beams/1.0/push-notifications-cdn.js"></script>

    <!-- Styles -->
    @livewireStyles
    <script type="module">
        window.Echo.private(`game-channel.{{ \Illuminate\Support\Facades\Auth::id() }}`)
            .listen('GameNotification', (e) => {
                Livewire.emit('MyGames');
                notifyIcon();
                document.title = "Kelimeo (1)";
                if (e.type === 1) {
                    notifyGame(e.username + " yeni OYUN isteği gönderdi!", "the-game/" + e.game);
                } else if (e.type === 2) {
                    notifyGame(e.username + " yeni REKABET isteği gönderdi!", "the-challenge-game/" + e.game);
                }else if (e.type === 23) {
                    notifyGame(e.username+" oyunu kazandı: "+e.word, "finished-challenge-game-watcher/" + e.previous);
                    setTimeout(function (){
                        notifyGame("Yeni Rekabet oyununa katıl!", "the-challenge-game/" + e.game);
                    },4500)

                }  else if (e.type === 3) {
                    notifyGame(e.username + " yeni DÜELLO isteği gönderdi!", "the-game/" + e.game + "/1");
                }

            });

        window.Echo.private(`guesses-channel.{{ \Illuminate\Support\Facades\Auth::id() }}`)
            .listen('GuessTyped', (e) => {
                let url = window.location.pathname;
                if (e.type === 1) {
                    if (e.isDuello === 0) {
                        if(url.indexOf("game-watcher/" + e.game) !== -1){
                            doldur(e.word);
                        }
                        else{
                            Livewire.emit('MyGames');
                            Livewire.emit('refreshLogs');
                            notifyGame(e.username + " tahminde bulundu!", "game-watcher/" + e.game);
                            notifyIcon();
                        }
                    } else if (e.isDuello === 1) {
                        if(url.indexOf(e.game + "/1") !== -1){
                            currentGuess = e.word;
                            checkGuess2(e.word);
                            activateDuello();
                        }
                        else{
                            notifyGame(e.username + " DÜELLO tahmininde bulundu!", "the-game/" + e.game + "/1");
                            Livewire.emit('MyGames');
                            notifyIcon();
                        }
                    }
                } else if (e.type === 2) {
                    let url = window.location.pathname;
                    if (url.indexOf('the-challenge-game') === -1) {
                        if(url.indexOf('finished-challenge-game-watcher/' + e.game + '/' + e.userId) !== -1){
                            doldur(e.word);
                        }
                        else if(url.indexOf('finished-challenge-game-watcher/' + e.game !== -1)){
                            notifyGame(e.username + " rekabet tahmininde bulundu!", "the-challenge-game/" + e.game);
                        }
                    } else {
                        let ypencil = "<svg width='14px' height='14px' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg' stroke='#facc15'><g id='SVGRepo_bgCarrier' stroke-width='0'></g><g id='SVGRepo_tracerCarrier' stroke-linecap='round' stroke-linejoin='round'></g><g id='SVGRepo_iconCarrier'><path fill-rule='evenodd' clip-rule='evenodd' d='m3.99 16.854-1.314 3.504a.75.75 0 0 0 .966.965l3.503-1.314a3 3 0 0 0 1.068-.687L18.36 9.175s-.354-1.061-1.414-2.122c-1.06-1.06-2.122-1.414-2.122-1.414L4.677 15.786a3 3 0 0 0-.687 1.068zm12.249-12.63 1.383-1.383c.248-.248.579-.406.925-.348.487.08 1.232.322 1.934 1.025.703.703.945 1.447 1.025 1.934.058.346-.1.677-.348.925L19.774 7.76s-.353-1.06-1.414-2.12c-1.06-1.062-2.121-1.415-2.121-1.415z' fill='#facc15'></path></g></svg>";
                        let bpencil = "<svg width='14px' height='14px' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg' stroke='red'><g id='SVGRepo_bgCarrier' stroke-width='0'></g><g id='SVGRepo_tracerCarrier' stroke-linecap='round' stroke-linejoin='round'></g><g id='SVGRepo_iconCarrier'><path fill-rule='evenodd' clip-rule='evenodd' d='m3.99 16.854-1.314 3.504a.75.75 0 0 0 .966.965l3.503-1.314a3 3 0 0 0 1.068-.687L18.36 9.175s-.354-1.061-1.414-2.122c-1.06-1.06-2.122-1.414-2.122-1.414L4.677 15.786a3 3 0 0 0-.687 1.068zm12.249-12.63 1.383-1.383c.248-.248.579-.406.925-.348.487.08 1.232.322 1.934 1.025.703.703.945 1.447 1.025 1.934.058.346-.1.677-.348.925L19.774 7.76s-.353-1.06-1.414-2.12c-1.06-1.062-2.121-1.415-2.121-1.415z' fill='red'></path></g></svg>";
                        let pstate = "y";
                        let blink = setInterval(function () {
                            if (pstate === "b") {
                                document.getElementById(e.userId).innerHTML = ypencil;
                                pstate = "y";
                            } else {
                                document.getElementById(e.userId).innerHTML = bpencil;
                                pstate = "b";
                            }
                        }, 100)

                        setTimeout(function () {
                            clearInterval(blink);
                            document.getElementById(e.userId).innerHTML = "<h2 class='mr-2 text-sm font-bold tracking-tight sm:text-center sm:text-4xl text-green-600'>" + e.username + "</h2>";
                        }, 1000)
                    }
                } else if (e.type === 3) {
                    notifyGame(e.username + " oyunu kazandı!", "finished-game-watcher/" + e.game);
                } else if (e.type === 4) {
                    notifyGame(e.username + " rekabeti kazandı!", "finished-challenge-game-watcher/" + e.game);
                    window.location.href = "/finished-challenge-game-watcher/" + e.game;
                }else if(e.type === 5){
                    notifyGame(e.username + " düelloyu kazandı!", "finished-game-watcher/" + e.game + "/1");
                    window.location.href = "/finished-game-watcher/" + e.game + "/1";
                }else if(e.type === 6){
                    if(url.indexOf(e.game + "/1") !== -1){
                        activateDuello();
                        notifyGame("Rakibin 3 defa hatalı kelime girdi", "the-game/" + e.game + "/1");
                    }
                    else{
                        notifyGame("Rakibin 3 defa hatalı kelime girdi", "the-game/" + e.game + "/1");
                    }
                }
                document.title = "Kelimeo (1)"
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
            }, 3500);
        }

        function notifyIcon() {
            document.getElementById('games').setAttribute('fill', '#EF4444');
        }
    </script>
    <div id="notifyBar"></div>
</head>
<body class="font-sans antialiased">
@php
    $unit=array('b','kb','mb','gb','tb','pb');
  //  echo @round(memory_get_usage()/pow(1024,($i=floor(log(memory_get_usage(),1024)))),2).' '.$unit[$i];
@endphp
<div class="min-h-screen bg-gray-100 dark:bg-gray-100">
    @auth
        <div name="welcome" class="mx-auto">
                <div class="back" @if(!str_contains(request()->path(), 'the-game') AND !str_contains(request()->path(), 'the-challenge-game')) style="display:none" @endif >
                    @if(str_contains(url()->previous(), 'the-game') OR str_contains(url()->previous(), 'the-challenge-game'))
                        <a href="/my-games">
                    @else
                        <a href="{{ url()->previous() }}">
                    @endif
                            <svg width="40px" height="40px" viewBox="0 0 1024 1024" fill="#4F46E5FF" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" stroke="#4F46E5FF" stroke-width="77.824"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M669.6 849.6c8.8 8 22.4 7.2 30.4-1.6s7.2-22.4-1.6-30.4l-309.6-280c-8-7.2-8-17.6 0-24.8l309.6-270.4c8.8-8 9.6-21.6 2.4-30.4-8-8.8-21.6-9.6-30.4-2.4L360.8 480.8c-27.2 24-28 64-0.8 88.8l309.6 280z" fill=""></path></g></svg>
                    </a>
                </div>
                <div>
                    <div class="bg-indigo-600 shadow-xl shadow-indigo-800 flex items-center px-2 py-4"
                         style="position:  fixed; bottom: 0; width: 100%; justify-content: space-evenly; z-index: 1000;
                         @if(str_contains(request()->path(), 'the-game') OR str_contains(request()->path(), 'the-challenge-game')) display: none @endif ">
                        <a href="/game-logs">
                            <svg fill="#facc15"
                                 @if(strpos(url()->current(), 'game-logs'))
                                 width="48px" height="48px"
                                 @else
                                 width="34px" height="34px"
                                 @endif
                                 viewBox="0 0 96 96"
                                 xmlns="http://www.w3.org/2000/svg" stroke="#facc15">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier"><title></title>
                                    <g>
                                        <path
                                            d="M58.3945,32.1563,42.9961,50.625l-5.3906-6.4629a5.995,5.995,0,1,0-9.211,7.6758l9.9961,12a5.9914,5.9914,0,0,0,9.211.0059l20.0039-24a5.9988,5.9988,0,1,0-9.211-7.6875Z"></path>
                                        <path
                                            d="M48,0A48,48,0,1,0,96,48,48.0512,48.0512,0,0,0,48,0Zm0,84A36,36,0,1,1,84,48,36.0393,36.0393,0,0,1,48,84Z"></path>
                                    </g>
                                </g>
                            </svg>
                        </a>

                        <a href="/create-game">
                            <svg fill="#FACC15"
                                 @if(strpos(url()->current(), 'create-game'))
                                 width="48px" height="48px"
                                 @else
                                 width="44px" height="44px"
                                 @endif viewBox="0 0 30 30" version="1.1"
                                 xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier"><title>plus</title>
                                    <path
                                        d="M15.5 29.5c-7.18 0-13-5.82-13-13s5.82-13 13-13 13 5.82 13 13-5.82 13-13 13zM21.938 15.938c0-0.552-0.448-1-1-1h-4v-4c0-0.552-0.447-1-1-1h-1c-0.553 0-1 0.448-1 1v4h-4c-0.553 0-1 0.448-1 1v1c0 0.553 0.447 1 1 1h4v4c0 0.553 0.447 1 1 1h1c0.553 0 1-0.447 1-1v-4h4c0.552 0 1-0.447 1-1v-1z"></path>
                                </g>
                            </svg>
                        </a>

                        <a href="/my-games">
                            <svg id="games"
                                 @if(strpos(url()->current(), 'my-games'))
                                 width="48px" height="48px"
                                 @else
                                 width="38px" height="38px"
                                 @endif viewBox="0 0 44 44"
                                 xmlns="http://www.w3.org/2000/svg"
                                 @if(\App\Models\Game::where('opponent_id', \Illuminate\Support\Facades\Auth::id())->where('seen', 0)->exists()
                                 OR App\Models\Game::where('user_id', \Illuminate\Support\Facades\Auth::id())->whereNull('winner_id')->where('isduello', '!=', 1)->where('seen2', 0)->exists()
                                 OR \App\Models\Game::where('isduello', 1)->where('sira', \Illuminate\Support\Facades\Auth::id())->whereNull('winner_id')->exists())
                                 fill="#EF4444"
                                 @else
                                 fill="#FACC15"
                                @endif
                            >
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path d="M0 0h48v48H0z" fill="none"></path>
                                    <g id="Shopicon">
                                        <path
                                            d="M24,44c11.046,0,20-8.954,20-20S35.046,4,24,4S4,12.954,4,24S12.954,44,24,44z M24,12c3.309,0,6,2.691,6,6 c0,2.642-1.331,3.938-2.302,4.885C26.712,23.846,26,24.54,26,26.999h-4c0-4.146,1.68-5.783,2.906-6.979 C25.702,19.244,26,18.954,26,18c0-1.103-0.897-2-2-2s-2,0.897-2,2h-4C18,14.691,20.691,12,24,12z M24,36c-1.105,0-2-0.895-2-2 c0-1.105,0.895-2,2-2c1.105,0,2,0.895,2,2C26,35.105,25.105,36,24,36z"></path>
                                    </g>
                                </g>
                            </svg>
                        </a>

                        <a href="/leader-board">
                            <svg
                                @if(strpos(url()->current(), 'leader-board'))
                                width="48px" height="48px"
                                @else
                                width="34px" height="34px"
                                @endif viewBox="0 0 6.3500002 6.3500002" id="svg1976" version="1.1"
                                xmlns="http://www.w3.org/2000/svg" xmlns:cc="http://creativecommons.org/ns#"
                                xmlns:dc="http://purl.org/dc/elements/1.1/"
                                xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape"
                                xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
                                xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd"
                                xmlns:svg="http://www.w3.org/2000/svg" fill="#FACC15">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <defs id="defs1970"></defs>
                                    <g id="layer1" style="display:inline">
                                        <path
                                            d="m 2.0062005,0.13306262 c -0.655029,0 -1.1895905,0.5345615 -1.1895905,1.18959148 0,0.64681 0.2600536,1.3675495 0.6175322,1.9549195 0.1787419,0.2936899 0.3818334,0.5542349 0.6051312,0.749825 0.2233004,0.1956001 0.471461,0.3379639 0.7539593,0.3379639 H 3.535307 c 0.2969207,0 0.5437558,-0.1660954 0.7658444,-0.3808553 C 4.5232321,3.7697473 4.7247864,3.4885823 4.9026657,3.1819722 5.2580858,2.5693422 5.5205604,1.8706771 5.5119297,1.320587 5.5108714,0.66644702 4.9767094,0.13306262 4.3223392,0.13306262 Z M 3.18339,0.93249702 A 0.26412889,0.265092 1.849479 0 1 3.3921647,1.0420511 L 3.6701836,1.417222 4.1388877,1.5944722 A 0.26412889,0.265092 1.849479 0 1 4.2608448,1.9954813 L 3.9890277,2.3794372 3.9652681,2.8791481 A 0.26412889,0.265092 1.849479 0 1 3.6200689,3.1194438 L 3.1766854,2.9783669 2.6935113,3.1116923 A 0.26412889,0.265092 1.849479 0 1 2.3591652,2.8589946 L 2.3555404,2.3892557 2.0821703,1.969643 A 0.26412889,0.265092 1.849479 0 1 2.2191133,1.5738016 L 2.6599145,1.4229064 2.9746231,1.0322326 a 0.26412889,0.265092 1.849479 0 1 0.1467618,-0.093018 0.26412889,0.265092 1.849479 0 1 0.06201,-0.00672 z"
                                            id="path698"
                                            style="color:#FACC15;font-style:normal;font-variant:normal;font-weight:normal;font-stretch:normal;font-size:medium;line-height:normal;font-family:sans-serif;font-variant-ligatures:normal;font-variant-position:normal;font-variant-caps:normal;font-variant-numeric:normal;font-variant-alternates:normal;font-variant-east-asian:normal;font-feature-settings:normal;font-variation-settings:normal;text-indent:0;text-align:start;text-decoration:none;text-decoration-line:none;text-decoration-style:solid;text-decoration-color:#FACC15;letter-spacing:normal;word-spacing:normal;text-transform:none;writing-mode:lr-tb;direction:ltr;text-orientation:mixed;dominant-baseline:auto;baseline-shift:baseline;text-anchor:start;white-space:normal;shape-padding:0;shape-margin:0;inline-size:0;clip-rule:nonzero;display:inline;overflow:visible;visibility:visible;isolation:auto;mix-blend-mode:normal;color-interpolation:sRGB;color-interpolation-filters:linearRGB;solid-color:#FACC15;solid-opacity:1;vector-effect:none;fill:#FACC15;fill-opacity:1;fill-rule:nonzero;stroke:none;stroke-width:0.529167;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke fill markers;color-rendering:auto;image-rendering:auto;shape-rendering:auto;text-rendering:auto;enable-background:accumulate;stop-color:#FACC15"></path>
                                        <path
                                            d="m 1.9300199,4.6290474 c -0.33744,0 -0.61719,0.2817 -0.61719,0.61914 v 0.35156 c 0,0.33744 0.27975,0.61719 0.61719,0.61719 h 2.46875 c 0.33743,0 0.61718,-0.27975 0.61718,-0.61719 v -0.35156 c 0,-0.33744 -0.27975,-0.61914 -0.61718,-0.61914 z"
                                            id="rect700"
                                            style="color:#FACC15;font-style:normal;font-variant:normal;font-weight:normal;font-stretch:normal;font-size:medium;line-height:normal;font-family:sans-serif;font-variant-ligatures:normal;font-variant-position:normal;font-variant-caps:normal;font-variant-numeric:normal;font-variant-alternates:normal;font-variant-east-asian:normal;font-feature-settings:normal;font-variation-settings:normal;text-indent:0;text-align:start;text-decoration:none;text-decoration-line:none;text-decoration-style:solid;text-decoration-color:#FACC15;letter-spacing:normal;word-spacing:normal;text-transform:none;writing-mode:lr-tb;direction:ltr;text-orientation:mixed;dominant-baseline:auto;baseline-shift:baseline;text-anchor:start;white-space:normal;shape-padding:0;shape-margin:0;inline-size:0;clip-rule:nonzero;display:inline;overflow:visible;visibility:visible;isolation:auto;mix-blend-mode:normal;color-interpolation:sRGB;color-interpolation-filters:linearRGB;solid-color:#FACC15;solid-opacity:1;vector-effect:none;fill:#FACC15;fill-opacity:1;fill-rule:nonzero;stroke:none;stroke-width:0.529167;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke fill markers;color-rendering:auto;image-rendering:auto;shape-rendering:auto;text-rendering:auto;enable-background:accumulate;stop-color:#FACC15"></path>
                                        <path
                                            d="M 0.2740077,0.92577912 A 0.26460996,0.26460996 0 0 0 0.0099403,1.1898457 c 0,0.67152 -0.031006,1.1590911 0.1896534,1.5585612 0.1103206,0.19973 0.2993496,0.3576738 0.5332994,0.4433838 0.1282436,0.046977 0.2711212,0.075923 0.4304666,0.093534 C 0.7981923,2.6501343 0.5380751,1.8953124 0.5380751,1.2125833 c 0,-0.098654 0.012515,-0.194166 0.033073,-0.28680418 z m 5.4833866,0 c 0.020399,0.092 0.032946,0.18679068 0.033073,0.28473708 C 5.8001245,1.8257351 5.5068127,2.6068281 5.1093715,3.2920429 5.2997947,3.2760277 5.4679666,3.2459638 5.6157999,3.1917907 5.8497603,3.1060908 6.0382548,2.9481369 6.1485834,2.7484069 6.3692353,2.3489368 6.3403031,1.8613657 6.3403031,1.1898457 A 0.26460996,0.26460996 0 0 0 6.0746879,0.92577912 Z"
                                            id="path702"
                                            style="color:#FACC15;font-style:normal;font-variant:normal;font-weight:normal;font-stretch:normal;font-size:medium;line-height:normal;font-family:sans-serif;font-variant-ligatures:normal;font-variant-position:normal;font-variant-caps:normal;font-variant-numeric:normal;font-variant-alternates:normal;font-variant-east-asian:normal;font-feature-settings:normal;font-variation-settings:normal;text-indent:0;text-align:start;text-decoration:none;text-decoration-line:none;text-decoration-style:solid;text-decoration-color:#FACC15;letter-spacing:normal;word-spacing:normal;text-transform:none;writing-mode:lr-tb;direction:ltr;text-orientation:mixed;dominant-baseline:auto;baseline-shift:baseline;text-anchor:start;white-space:normal;shape-padding:0;shape-margin:0;inline-size:0;clip-rule:nonzero;display:inline;overflow:visible;visibility:visible;isolation:auto;mix-blend-mode:normal;color-interpolation:sRGB;color-interpolation-filters:linearRGB;solid-color:#FACC15;solid-opacity:1;vector-effect:none;fill:#FACC15;fill-opacity:1;fill-rule:nonzero;stroke:none;stroke-width:0.529167;stroke-linecap:butt;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;color-rendering:auto;image-rendering:auto;shape-rendering:auto;text-rendering:auto;enable-background:accumulate;stop-color:#FACC15"></path>
                                    </g>
                                </g>
                            </svg>
                        </a>
                        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                            <button
                                class="px-2 py-3 font-medium  shadow-xl  hover:bg-white duration-150  bg-yellow-400 @if($myProfileColor)border-b-2 border-gray-800 @endif">
                                <img class="h-8 w-8 rounded-full object-cover"
                                     src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}"/>
                            </button>
                        @else

                            <a href="/my-profile">
                                <svg
                                    @if(strpos(url()->current(), 'my-profile'))
                                    width="48px" height="48px"
                                    @else
                                    width="34px" height="34px"
                                    @endif viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <g id="style=fill">
                                            <g id="profile">
                                                <path id="vector (Stroke)" fill-rule="evenodd" clip-rule="evenodd"
                                                      d="M6.75 6.5C6.75 3.6005 9.1005 1.25 12 1.25C14.8995 1.25 17.25 3.6005 17.25 6.5C17.25 9.3995 14.8995 11.75 12 11.75C9.1005 11.75 6.75 9.3995 6.75 6.5Z"
                                                      fill="#FACC15"></path>
                                                <path id="rec (Stroke)" fill-rule="evenodd" clip-rule="evenodd"
                                                      d="M4.25 18.5714C4.25 15.6325 6.63249 13.25 9.57143 13.25H14.4286C17.3675 13.25 19.75 15.6325 19.75 18.5714C19.75 20.8792 17.8792 22.75 15.5714 22.75H8.42857C6.12081 22.75 4.25 20.8792 4.25 18.5714Z"
                                                      fill="#FACC15"></path>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>

        </div>
        <!-- Page Content -->
        <main class="py-3">
            {{ $slot }}
        </main>
        <div class="flex justify-center p-10">
            <a href="/my-games">
            <h2 class="text-2xl font-bold tracking-tight sm:text-center sm:text-4xl text-indigo-500">
                KELİMEO</h2>
            </a>
        </div>
    @else
        <x-guest-layout>
            <x-jet-authentication-card>
                    <x-slot name="logo">
                        <x-jet-authentication-card-logo/>
                    </x-slot>
                    <div class="flex justify-center">
                        <div class="m-auto">
                            <h1 class="text-center font-bold">Nasıl oynanır?</h1>
                            <ul class="border border-gray-200 rounded overflow-hidden shadow-md mt-2">
                                <li class="px-4 py-2 bg-white hover:bg-sky-100 hover:text-sky-900 border-b last:border-none border-gray-200 transition-all duration-300 ease-in-out">
                                    Size verilen kelimeyi tahmin etmeye
                                    çalışırsınız
                                </li>
                                <li class="px-4 py-2 bg-white hover:bg-sky-100 hover:text-sky-900 border-b last:border-none border-gray-200 transition-all duration-300 ease-in-out">
                                    Harfler kelimedeki yerlerinin doğruluğuna göre renk alır
                                </li>
                                <li class="px-4 py-2 bg-white hover:bg-sky-100 hover:text-sky-900 border-b last:border-none border-gray-200 transition-all duration-300 ease-in-out">
                                    Örnek kelimemiz "DÜNYA" olsun
                                </li>
                                <li class="px-4 py-2 bg-white hover:bg-sky-100 hover:text-sky-900 border-b last:border-none border-gray-200 transition-all duration-300 ease-in-out">
                                    "KOL<span class="bg-green-600 p-2 text-white">Y</span>E" yazarsanız "Y" harfi doğru
                                    yerde olacağı için yeşil yanar
                                </li>
                                <li class="px-4 py-2 bg-white hover:bg-sky-100 hover:text-sky-900 border-b last:border-none border-gray-200 transition-all duration-300 ease-in-out">
                                    "<span class="bg-yellow-400 p-2 text-white">A</span>RMUT" yazarsanız "A" harfi
                                    yanlış yerde olduğu için sarı yanar.
                                </li>
                                <li class="px-4 py-2 bg-white hover:bg-sky-100 hover:text-sky-900 border-b last:border-none border-gray-200 transition-all duration-300 ease-in-out">
                                    Kelimede olmayan diğer harfler gri yanar.
                                </li>
                                <li class="px-4 py-2 bg-white hover:bg-sky-100 hover:text-sky-900 border-b last:border-none border-gray-200 transition-all duration-300 ease-in-out">
                                    Oyunun 3 modu var: Klasik mod, rekabet modu ve düello
                                </li>
                                <li class="px-4 py-2 bg-white hover:bg-sky-100 hover:text-sky-900 border-b last:border-none border-gray-200 transition-all duration-300 ease-in-out">
                                    Klasik mod: Arkadaşınıza kelime sorarsınız, bulmaya çalışır.
                                </li>
                                <li class="px-4 py-2 bg-white hover:bg-sky-100 hover:text-sky-900 border-b last:border-none border-gray-200 transition-all duration-300 ease-in-out">
                                    Rekabet modu: Bilgisayarın seçtiği bir kelimeyi grubunuzdan ilk bulan kazanır.
                                </li>
                                <li class="px-4 py-2 bg-white hover:bg-sky-100 hover:text-sky-900 border-b last:border-none border-gray-200 transition-all duration-300 ease-in-out">
                                    Düello: Bilgisayarın seçtiği kelimeyi arkadaşınız ile sırayla bulmaya çalışırsınız.
                                </li>
                            </ul>
                        </div>
                    </div>

                <x-jet-validation-errors class="mb-4"/>

                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="flex justify-center w-full">
                <a href="{{ route('register') }}">
                    <button
                        class="mt-4 px-3 py-3 font-medium text-slate-700 shadow-xl bg-yellow-400 bg- duration-150"
                        type="button">
                        Üye olmak için tıklayın
                    </button>
                </a>
                </div>
                <div class="shadow-md p-6 border mt-4">
                <div class="flex justify-center mb-2">
                    <h2 class="text-2xl font-bold tracking-tight sm:text-center sm:text-4xl text-indigo-500">
                        Zaten üye misiniz?</h2>
                </div>
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
                    <div class="flex justify-center mt-4">
                        <a href="mailto:hello@kelimeo.com" class="text-xs text-center block mt-4 hover:underline">Sorularınız
                            için: hello@kelimeo.com</a>
                    </div>
                </form>
                </div>
            </x-jet-authentication-card>
        </x-guest-layout>
    @endauth
        <script>
            const beamsClient = new PusherPushNotifications.Client({
                instanceId: 'b057dbbd-15b7-48ba-9ce3-6e9bfa5e3bba',
            });

            beamsClient.start()
                .then(() => beamsClient.addDeviceInterest('hello'))
                .then(() => console.log('Successfully registered and subscribed!'))
                .catch(console.error);
        </script>
</div>

@stack('modals')

@livewireScripts

</body>
</html>
