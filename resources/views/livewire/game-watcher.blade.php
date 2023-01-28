<div name="the-game">
    <div class="flex justify-center mb-4">
        <a href="/user-summary/{{ \App\Models\User::where('username', $opponentName)->first()->id }}">
        <h2 class="text-2xl font-bold tracking-tight sm:text-center sm:text-4xl text-indigo-500">{{ $opponentName }}: </h2></a>
        <h2 class="text-2xl font-bold tracking-tight sm:text-center sm:text-4xl text-red-600"> {{ $wordName }}</h2>
        @if(\Illuminate\Support\Facades\Cache::has('user-is-online-' . \App\Models\User::where('username', $opponentName)->first()->id))
            <span style="background-color: chartreuse; height: 40px;
  width: 40px;
  border-radius: 50%;
  display: inline-block;">&nbsp;</span>
        @else
            <span style="background-color: #494949 ; height: 25px;
  width: 25px;
  border-radius: 50%;
  display: inline-block;">&nbsp;</span>
        @endif
    </div>
    <div class="flex justify-center">
        <h2>Son tahmin: {{ $lastGuessTime }}</h2>
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
    <div id="keyboard-cont">
        <div class="first-row">
            <button class="keyboard-button">e</button>
            <button class="keyboard-button">r</button>
            <button class="keyboard-button">t</button>
            <button class="keyboard-button">y</button>
            <button class="keyboard-button">u</button>
            <button class="keyboard-button">ı</button>
            <button class="keyboard-button">o</button>
            <button class="keyboard-button">p</button>
            <button class="keyboard-button">ğ</button>
            <button class="keyboard-button">ü</button>
        </div>
        <div class="second-row">
            <button class="keyboard-button">a</button>
            <button class="keyboard-button">s</button>
            <button class="keyboard-button">d</button>
            <button class="keyboard-button">f</button>
            <button class="keyboard-button">g</button>
            <button class="keyboard-button">h</button>
            <button class="keyboard-button">j</button>
            <button class="keyboard-button">k</button>
            <button class="keyboard-button">l</button>
            <button class="keyboard-button">ş</button>
            <button class="keyboard-button">i</button>
        </div>
        <div class="third-row">
            <button class="keyboard-button">Del</button>
            <button class="keyboard-button">z</button>
            <button class="keyboard-button">c</button>
            <button class="keyboard-button">v</button>
            <button class="keyboard-button">b</button>
            <button class="keyboard-button">n</button>
            <button class="keyboard-button">m</button>
            <button class="keyboard-button">ö</button>
            <button class="keyboard-button">ç</button>
            <button class="keyboard-button">Enter</button>
        </div>
    </div>
    <script>
        let words = JSON.parse({!! json_encode(\App\Models\Word::pluck('name')->toJSON()) !!})
        const NUMBER_OF_GUESSES = {{ $length + 1}};

        let guesses = @json($guessesArray);
        let guessesRemaining = NUMBER_OF_GUESSES;
        let currentGuess = [];
        let nextLetter = 0;
        let rightGuessString = "{{ \App\Models\Game::find($gameId)->word->name }}";

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
        if(guesses !== null){

            guesses.forEach(function (k){
                Array.from(k).forEach(function (m){
                    addedLetter = String(m);
                    insertAddedLetter(addedLetter, k);
                })
            })
        }

        function refreshWatcher()
        {
            Livewire.emit('refreshGameWatcher');
        }


        function insertAddedLetter (addedLetter, k) {

            let row = document.getElementsByClassName("letter-row")[addedGuessesCount]
            let box = row.children[nextAddedLetter];

            currentGuess.push(addedLetter)
            if (nextAddedLetter === {{ $length }} - 1){
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


        function checkAddedGuess (a) {
            let row = document.getElementsByClassName("letter-row")[{{ $length + 1 }} - a]
            let guessString = ''
            let rightGuess = Array.from(rightGuessString)

            for (const val of currentGuess) {
                guessString += val
            }



            for (let i = 0; i < {{ $length }}; i++) {
                let letterColor = ''
                let box = row.children[i]
                let letter = currentGuess[i]

                let letterPosition = rightGuess.indexOf(currentGuess[i])

                // is letter in the correct guess?
                if (letterPosition === -1) {
                    letterColor = '#e3e3e3'
                } else {
                    // now, letter is definitely in word
                    // if letter index and right guess index are the same
                    // letter is in the right position
                    if (currentGuess[i] === rightGuess[i]) {
                        // shade green
                        letterColor = '#02cc09'
                    } else {
                        // shade box yellow
                        letterColor = 'yellow'
                    }

                    rightGuess[letterPosition] = "#"
                }

                box.style.backgroundColor = letterColor;
                shadeKeyBoard(letter, letterColor)
            }



            if (guessString === rightGuessString) {
                notifyGame("Malesef rakibin kelimeyi bildi!")
                guessesRemaining = 0
                return
            } else {
                guessesRemaining -= 1;
                currentGuess = [];
                nextLetter = 0;

                if (guessesRemaining === 0) {
                    notifyGame(`Kazandın! Rakibin bilemedi: ${rightGuessString}`)
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
    <script   src="https://code.jquery.com/jquery-3.6.3.min.js"   integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU="   crossorigin="anonymous"></script>
</div>
