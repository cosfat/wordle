<div>
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />
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
            border: 2px solid gray;
            border-radius: 3px;
            margin: 2px;
            font-size: 2.5rem;
            font-weight: 700;
            height: 3rem;
            width: 3rem;
            display: flex;
            justify-content: center;
            align-items: center;
            text-transform: uppercase;
        }

        .filled-box {
            border: 2px solid black;
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
            <button class="keyboard-button">q</button>
            <button class="keyboard-button">w</button>
            <button class="keyboard-button">e</button>
            <button class="keyboard-button">r</button>
            <button class="keyboard-button">t</button>
            <button class="keyboard-button">y</button>
            <button class="keyboard-button">u</button>
            <button class="keyboard-button">i</button>
            <button class="keyboard-button">o</button>
            <button class="keyboard-button">p</button>
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
        </div>
        <div class="third-row">
            <button class="keyboard-button">Del</button>
            <button class="keyboard-button">z</button>
            <button class="keyboard-button">x</button>
            <button class="keyboard-button">c</button>
            <button class="keyboard-button">v</button>
            <button class="keyboard-button">b</button>
            <button class="keyboard-button">n</button>
            <button class="keyboard-button">m</button>
            <button class="keyboard-button">Enter</button>
        </div>
    </div>
    <script>
        let words = JSON.parse({!! json_encode(\App\Models\Word::pluck('name')->toJSON()) !!})
        const NUMBER_OF_GUESSES = 6;
        let guessesRemaining = NUMBER_OF_GUESSES;
        let currentGuess = [];
        let nextLetter = 0;
        let rightGuessString = "{{ \App\Models\Game::find($gameId)->word->name }}";

        function initBoard() {
            let board = document.getElementById("game-board");

            for (let i = 0; i < NUMBER_OF_GUESSES; i++) {
                let row = document.createElement("div")
                row.className = "letter-row"

                for (let j = 0; j < 5; j++) {
                    let box = document.createElement("div")
                    box.className = "letter-box"
                    row.appendChild(box)
                }

                board.appendChild(row)
            }
        }

        initBoard()

        document.addEventListener("keyup", (e) => {

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

            let found = pressedKey.match(/[a-z]/gi)
            if (!found || found.length > 1) {
                return
            } else {
                insertLetter(pressedKey)
            }
        })

        function insertLetter (pressedKey) {
            if (nextLetter === 5) {
                return
            }
            pressedKey = pressedKey.toLowerCase()

            let row = document.getElementsByClassName("letter-row")[6 - guessesRemaining]
            let box = row.children[nextLetter]
            animateCSS(box, "pulse")
            box.textContent = pressedKey
            box.classList.add("filled-box")
            currentGuess.push(pressedKey)
            nextLetter += 1
        }

        function deleteLetter () {
            let row = document.getElementsByClassName("letter-row")[6 - guessesRemaining]
            let box = row.children[nextLetter - 1]
            box.textContent = ""
            box.classList.remove("filled-box")
            currentGuess.pop()
            nextLetter -= 1
        }
        function checkGuess () {
            let row = document.getElementsByClassName("letter-row")[6 - guessesRemaining]
            let guessString = ''
            let rightGuess = Array.from(rightGuessString)

            for (const val of currentGuess) {
                guessString += val
            }

            if (guessString.length != 5) {
                notifyGame("5 harfli kelime yazmalısın")
                return
            }

            if (!words.includes(guessString)) {
                notifyGame("Bu kelime veritabanımızda yok")
                return
            }


            for (let i = 0; i < 5; i++) {
                let letterColor = ''
                let box = row.children[i]
                let letter = currentGuess[i]

                let letterPosition = rightGuess.indexOf(currentGuess[i])
                // is letter in the correct guess
                if (letterPosition === -1) {
                    letterColor = 'grey'
                } else {
                    // now, letter is definitely in word
                    // if letter index and right guess index are the same
                    // letter is in the right position
                    if (currentGuess[i] === rightGuess[i]) {
                        // shade green
                        letterColor = 'green'
                    } else {
                        // shade box yellow
                        letterColor = 'yellow'
                    }

                    rightGuess[letterPosition] = "#"
                }

                let delay = 250 * i
                setTimeout(()=> {
                    animateCSS(box, 'flipInX')
                    //shade box
                    box.style.backgroundColor = letterColor
                    shadeKeyBoard(letter, letterColor)
                }, delay)
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

            if (key === "Del") {
                key = "Backspace"
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
    <script   src="https://code.jquery.com/jquery-3.6.3.min.js"   integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU="   crossorigin="anonymous"></script>
</div>
