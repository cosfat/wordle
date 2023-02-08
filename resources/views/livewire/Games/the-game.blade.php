<div name="the-game">
    @include('loading')
    <div class="flex justify-center mb-4">
        <a href="/user-summary/{{ \App\Models\User::where('username', $opponentName)->first()->id }}">
            <h2 class="text-2xl font-bold tracking-tight sm:text-center sm:text-4xl text-indigo-500">{{ $opponentName }}</h2>
        </a>
        @if(\Illuminate\Support\Facades\Cache::has('user-is-online-' . \App\Models\User::where('username', $opponentName)->first()->id))
            <span class="mt-2 ml-2" style="background-color: chartreuse; height: 25px;
  width: 25px;
  border-radius: 50%;
  display: inline-block;">&nbsp;</span>
        @else
            <span class="mt-2 ml-2" style="background-color: #494949 ; height: 25px;
  width: 25px;
  border-radius: 50%;
  display: inline-block;">&nbsp;</span>
        @endif
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
            <button class="keyboard-button">SİL</button>
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
        <div class="fourth-row mt-2">
            <button class="keyboard-button bg-red-500 text-white">TEMİZLE</button>
        </div>
    </div>
    <livewire:chat-wire :gameId="$gameId" :gameType="1" />
    <script>
        let words = JSON.parse({!! json_encode(\App\Models\Word::pluck('name')->toJSON()) !!})
        let guesses = @json($guessesArray);

        let chatMode = false;

        document.getElementById('chatInput').onfocus = function (){
            chatMode = true
        }

        document.getElementById('chatInput').onblur = function (){
            chatMode = false;
        }

        const NUMBER_OF_GUESSES = {{ $length + 1 }};
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


            document.addEventListener("keyup", (e) => {
if(chatMode === false){
    if (guessesRemaining === 0) {
        return
    }

    let pressedKey = String(e.key)
    if (pressedKey === "Backspace" && nextLetter !== 0) {
        deleteLetter()
        return
    }

    if (pressedKey === "Enter") {
        checkGuess()
        return
    }

    let found = pressedKey.match(/[a-zöçşıİğü]/gi)
    if (!found || found.length > 1) {
        return
    } else {
        insertLetter(pressedKey)
    }
}

            })



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
                notifyGame("Tebrikler!")
                guessesRemaining = 0
                return
            } else {
                guessesRemaining -= 1;
                currentGuess = [];
                nextLetter = 0;

                if (guessesRemaining === 0) {
                    notifyGame(`Kaybettin! Doğru kelime: ${rightGuessString}`)
                }
            }
        }

        function insertLetter(pressedKey) {
            if (nextLetter === {{ $length }}) {
                return
            }
            pressedKey = pressedKey.toLowerCase()

            let row = document.getElementsByClassName("letter-row")[{{ $length + 1 }} - guessesRemaining]
            let box = row.children[nextLetter]
            animateCSS(box, "pulse")
            box.textContent = pressedKey
            box.classList.add("filled-box")
            currentGuess.push(pressedKey)
            nextLetter += 1
        }

        function deleteLetter() {
            let row = document.getElementsByClassName("letter-row")[{{ $length + 1 }} - guessesRemaining]
            let box = row.children[nextLetter - 1]
            box.textContent = ""
            box.classList.remove("filled-box")
            currentGuess.pop()
            nextLetter -= 1
        }

        function checkGuess() {
            let row = document.getElementsByClassName("letter-row")[{{ $length + 1 }} - guessesRemaining]
            let guessString = ''
            let rightGuess = Array.from(rightGuessString)

            for (const val of currentGuess) {
                guessString += val
            }

            if (guessString.length != {{ $length }}) {
                notifyGame("{{ $length }} harfli kelime yazmalısın")
                return
            }

            if (!words.includes(guessString)) {
                notifyGame("Bu kelime veritabanımızda yok")
                return
            }


            for (let i = 0; i < {{ $length }}; i++) {

                let letterColor = ''
                let box = row.children[i]
                let letter = currentGuess[i]

                let letterPosition = rightGuess.indexOf(currentGuess[i])
                // is letter in the correct guess
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


                let delay = 250 * i
                setTimeout(() => {
                    animateCSS(box, 'flipInX')
                    //shade box
                    box.style.backgroundColor = letterColor
                    shadeKeyBoard(letter, letterColor)
                }, delay)
            }


            var wordNumber = {{ $length + 1 }} - guessesRemaining;

            Livewire.emit('addGuess', guessString, {{ $gameId }});
            if (guessString === rightGuessString) {
                notifyGame("Tebrikler!")
                guessesRemaining = 0;
                Livewire.emit('winner');
                return
            } else {
                guessesRemaining -= 1;
                currentGuess = [];
                nextLetter = 0;

                if (guessesRemaining === 0) {
                    notifyGame(`Kaybettin! Doğru kelime: ${rightGuessString}`);
                    Livewire.emit('loser');
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

        document.getElementById("keyboard-cont").addEventListener("click", (e) => {
            const target = e.target

            if (!target.classList.contains("keyboard-button")) {
                return
            }
            let key = target.textContent

            if (key === "SİL") {
                key = "Backspace"
            }
            if (key === "TEMİZLE") {
                key = "Backspace";
                for (x = 0; x < 8; x++) {
                    document.dispatchEvent(new KeyboardEvent("keyup", {'key': key}))
                }
            }

            document.dispatchEvent(new KeyboardEvent("keyup", {'key': key}))
        })

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
    <livewire:games.guess-recorder></livewire:games.guess-recorder>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"
            integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
</div>
