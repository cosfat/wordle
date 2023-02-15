<div name="finished-game-watcher">
    @include('loading')
    <div class="flex justify-center flex-wrap">
        @foreach(\App\Models\Challenge::whereId($gameId)->first()->chusers()->get() as $user)
            <a href="/finished-challenge-game-watcher/{{ $gameId }}/{{ $user->user_id }}">
                <div style="width: 140px"
                    class="overflow-hidden flex justify-center px-3 py-3 font-medium text-slate-700 shadow-xl @if($userId == $user->user_id)) bg-white @else bg-yellow-400 @endif hover:bg-white duration-150">

                    @if(\App\Models\Challenge::whereId($gameId)->first()->winner_id == $user->user_id)

                        <svg class="mr-2" fill="#4F46E5" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                             xmlns:xlink="http://www.w3.org/1999/xlink" width="20px" height="20px"
                             viewBox="0 0 145.312 145.311" xml:space="preserve" stroke="#4F46E5"><g
                                id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <g>
                                    <path
                                        d="M115.451,132.818c0,1.487-1.207,2.7-2.699,2.7H32.563c-1.492,0-2.7-1.213-2.7-2.7s1.208-2.7,2.7-2.7h80.188 C114.244,130.118,115.451,131.321,115.451,132.818z M145.167,29.627l-31.408,91.626c-0.369,1.092-1.393,1.825-2.553,1.825H34.101 c-1.154,0-2.18-0.733-2.552-1.825L0.146,29.627c-0.253-0.741-0.172-1.55,0.216-2.226c0.391-0.675,1.05-1.149,1.817-1.302 c17.479-3.472,36.215-0.087,50.838,9.034l17.442-24.282c1.015-1.411,3.37-1.411,4.385,0l17.441,24.282 c14.623-9.121,33.37-12.501,50.842-9.034c0.765,0.153,1.429,0.627,1.819,1.302C145.336,28.083,145.421,28.892,145.167,29.627z M46.678,49.082c-6.565-4.485-14.407-7.473-22.667-8.648c-0.936-0.143-1.854,0.227-2.452,0.943 c-0.601,0.718-0.789,1.696-0.493,2.582l13.205,39.7c0.377,1.135,1.429,1.846,2.565,1.846c0.28,0,0.567-0.042,0.852-0.131 c1.416-0.47,2.184-1.999,1.711-3.412L27.644,46.608c5.816,1.355,11.28,3.723,16,6.945c1.226,0.833,2.906,0.524,3.752-0.707 C48.239,51.61,47.909,49.93,46.678,49.082z"></path>
                                </g>
                            </g></svg>
                    @else
                        <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"
                             xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                             fill="#000000">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier"><title>angry</title>
                                <desc>Created with sketchtool.</desc>
                                <g id="people" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <g id="angry" fill="#000000">
                                        <path
                                            d="M12,22 C6.4771525,22 2,17.5228475 2,12 C2,6.4771525 6.4771525,2 12,2 C17.5228475,2 22,6.4771525 22,12 C22,17.5228475 17.5228475,22 12,22 Z M12,20 C16.418278,20 20,16.418278 20,12 C20,7.581722 16.418278,4 12,4 C7.581722,4 4,7.581722 4,12 C4,16.418278 7.581722,20 12,20 Z M16,17 L14.6611201,17 C14.6611201,17 14.2442153,14.3333333 12,14.3333333 C9.75578467,14.3333333 9.33333333,17 9.33333333,17 L8,17 C8,14.790861 9.790861,13 12,13 C14.209139,13 16,14.790861 16,17 Z M10.506405,8.98983837 C10.7565765,9.25783918 10.909675,9.61762369 10.909675,10.0131663 C10.909675,10.8415934 10.2381021,11.5131663 9.40967501,11.5131663 C8.58124788,11.5131663 7.90967501,10.8415934 7.90967501,10.0131663 C7.90967501,9.33142915 8.36447289,8.75591575 8.98721669,8.57347804 L7.329126,7.96998239 C7.06963705,7.87553613 6.93584351,7.58861496 7.03028977,7.329126 C7.12473602,7.06963705 7.4116572,6.93584351 7.67114615,7.03028977 L10.490224,8.0563502 C10.749713,8.15079645 10.8835065,8.43771763 10.7890602,8.69720658 C10.7386018,8.83584008 10.6332053,8.93859642 10.506405,8.98983837 Z M13.40327,8.98983837 C13.2764697,8.93859642 13.1710732,8.83584008 13.1206148,8.69720658 C13.0261685,8.43771763 13.159962,8.15079645 13.419451,8.0563502 L16.2385289,7.03028977 C16.4980178,6.93584351 16.784939,7.06963705 16.8793852,7.329126 C16.9738315,7.58861496 16.840038,7.87553613 16.580549,7.96998239 L14.9224583,8.57347804 C15.5452021,8.75591575 16,9.33142915 16,10.0131663 C16,10.8415934 15.3284271,11.5131663 14.5,11.5131663 C13.6715729,11.5131663 13,10.8415934 13,10.0131663 C13,9.61762369 13.1530985,9.25783918 13.40327,8.98983837 Z"
                                            id="Shape"></path>
                                    </g>
                                </g>
                            </g>
                        </svg>
                    @endif
                    <h2>
                        {{ \App\Models\User::whereId($user->user_id)->first()->name }}
                    </h2>
                </div>
            </a> @endforeach
    </div>
    <div class="flex justify-center">
        <h2 class="text-2xl font-bold tracking-tight sm:text-center sm:text-4xl text-red-600">{{ $wordName }}</h2>
    </div>
    <div class="flex justify-center px-4">
        <span class="text-sm">"{{ $meaning }}"</span>
    </div>
    <div class="flex justify-center px-4">
        <span class="text-sm text-gray-600">{{ \App\Models\Challenge::find($gameId)->created_at->diffForHumans() }} <strong> - {{ $point }} puan -
               {{ $duration }}
            </strong></span>
    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        h1 {
            text-align: center;
        }

        #game-board {
            display: flex;
            align-items: center;
            flex-direction: column;
        }

        .letter-box {
            border: 4px solid #4f46e5;
            border-radius: 3px;
            margin: 2px;
            font-size: 2rem;
            font-weight: 700;
            height: 3rem;
            width: 3rem;
            display: flex;
            justify-content: center;
            align-items: center;
            text-transform: uppercase;
        }

        .filled-box {
            border: 4px solid #facc15;
        }

        .letter-row {
            display: flex;
        }

        #keyboard-cont {
            margin: 1rem 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        #keyboard-cont div {
            display: flex;
        }

        .second-row {
            margin: 0.5rem 0;
        }

        .keyboard-button {
            font-size: 1rem;
            font-weight: 700;
            padding: 0.5rem;
            margin: 0 2px;
            cursor: pointer;
            text-transform: uppercase;
        }
    </style>
    <div id="game-board">
    </div>
    @if($chat)
        <livewire:chat-wire :gameId="$gameId" :gameType="2" />
    @endif
    <script>
        let words = JSON.parse({!! json_encode(\App\Models\Word::pluck('name')->toJSON()) !!})
        const NUMBER_OF_GUESSES = {{ $length + 1}};

        let guesses = @json($guessesArray);
        let guessesRemaining = NUMBER_OF_GUESSES;
        let currentGuess = [];
        let nextLetter = 0;
        let rightGuessString = "{{ \App\Models\Challenge::find($gameId)->word->name }}";

        function initBoard() {
            let board = document.getElementById("game-board");

            for (let i = 0; i < NUMBER_OF_GUESSES; i++) {
                let row = document.createElement("div")
                row.className = "letter-row"

                for (let j = 0; j < {{ $length }}; j++) {
                    let box = document.createElement("div")
                    box.className = "letter-box"
                    row.appendChild(box)
                }

                board.appendChild(row)
            }
        }

        initBoard()


        let addedGuessesCount = 0;
        let nextAddedLetter = 0;
        let addedRow = {{ $length + 1 }};
        if (guesses !== null) {

            guesses.forEach(function (k) {
                Array.from(k).forEach(function (m) {
                    addedLetter = String(m);
                    insertAddedLetter(addedLetter, k);
                })
            })
        }

        function refreshWatcher() {
            Livewire.emit('refreshGameWatcher');
        }


        function insertAddedLetter(addedLetter, k) {

            let row = document.getElementsByClassName("letter-row")[addedGuessesCount]
            let box = row.children[nextAddedLetter];

            currentGuess.push(addedLetter)
            if (nextAddedLetter === {{ $length }} - 1) {
                checkAddedGuess(addedRow);
                nextAddedLetter = -1;
                addedGuessesCount += 1;
                addedRow -= 1;
            }

            addedLetter = addedLetter.toLowerCase()
            box.textContent = addedLetter
            box.classList.add("filled-box")

            nextAddedLetter += 1

        }


        function checkAddedGuess(a) {
            let row = document.getElementsByClassName("letter-row")[{{ $length + 1 }} - a]
            let guessString = ''
            let rightGuess = Array.from(rightGuessString)

            for (const val of currentGuess) {
                guessString += val
            }
            const matches = [];
            const greens = [];
            const yellows = [];
            for(let i = 0; i < {{ $length }}; i ++){
                for(let k = 0; k < {{ $length }}; k++){
                    if(currentGuess[i] === rightGuess[k]){
                        matches.push(i)
                    }
                }
            }
            for(let x = 0; x < matches.length; x++){
                if(currentGuess[matches[x]] === rightGuess[matches[x]]){
                    console.log(currentGuess[matches[x]])
                    greens.push(matches[x])
                    rightGuess[matches[x]] = "#"
                }
                else{
                    yellows.push(matches[x]);
                }
            }
            for(let x = 0; x<greens.length; x++){
                for(let y = 0; y<yellows.length; y++){
                    if(currentGuess[greens[x]] === currentGuess[yellows[y]]){
                        delete yellows[y]
                    }
                }
            }
            let yellowsU = yellows.filter((value, index, array) => array.indexOf(value) === index);
            let greensU = greens.filter((value, index, array) => array.indexOf(value) === index);


            for (let i = 0; i < {{ $length }}; i++) {
                let letterColor = ''
                let box = row.children[i]
                let letter = currentGuess[i]

                if(greensU.indexOf(i) !== -1){
                    letterColor = '#02cc09'
                }
                else if(yellowsU.indexOf(i) !== -1){
                    letterColor = 'yellow'
                }
                else{
                    letterColor = '#e3e3e3'
                }

                box.style.backgroundColor = letterColor;
                shadeKeyBoard(letter, letterColor)
            }


            if (guessString === rightGuessString) {
                notifyGame("{{ $userName }} kelimeyi bildi!")
                guessesRemaining = 0
                return
            } else {
                guessesRemaining -= 1;
                currentGuess = [];
                nextLetter = 0;

                if (guessesRemaining === 0) {
                    notifyGame(`{{ $userName }} kelimeyi bilemedi: ${rightGuessString}`)
                }
            }
        }

        function shadeKeyBoard(letter, color) {
            for (const elem of document.getElementsByClassName("keyboard-button")) {
                if (elem.textContent === letter) {
                    let oldColor = elem.style.backgroundColor
                    if (oldColor === 'green') {
                        return
                    }

                    if (oldColor === 'yellow' && color !== 'green') {
                        return
                    }

                    elem.style.backgroundColor = color
                    break
                }
            }
        }

        const animateCSS = (element, animation, prefix = 'animate__') =>
            // We create a Promise and return it
            new Promise((resolve, reject) => {
                const animationName = `${prefix}${animation}`;
                // const node = document.querySelector(element);
                const node = element
                node.style.setProperty('--animate-duration', '0.3s');

                node.classList.add(`${prefix}animated`, animationName);

                // When the animation ends, we clean the classes and resolve the Promise
                function handleAnimationEnd(event) {
                    event.stopPropagation();
                    node.classList.remove(`${prefix}animated`, animationName);
                    resolve('Animation ended');
                }

                node.addEventListener('animationend', handleAnimationEnd, {once: true});
            });
    </script>

    @if (session()->has('message'))
        <script>
            notifyGame("{{  session('message')  }}")
        </script>
    @endif
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"
            integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
</div>
