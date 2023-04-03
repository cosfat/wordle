<div name="the-game">
    <div class="flex justify-center mb-2">
        @if($opponentName == "Günün Kelimesi")
            <h2 class="text-2xl font-bold tracking-tight sm:text-center sm:text-4xl text-indigo-500">{{ $opponentName }}</h2>
        @else

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
        @endif
    </div>
    <div id="duelloAlert" class="flex justify-center text-sm bg-indigo-500 text-white p-2 mb-2">
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    @if($isDuello != 1)
        <livewire:games.live-counter :start="$start" :firstGuess="$firstGuess"></livewire:games.live-counter>
    @endif
    <div id="game-board">
    </div>
    @if(count($frequents) != 0)
        <div class="flex justify-center text-sm mt-2">
            @foreach($frequents as $word)
               <span class="cursor-pointer mr-2" onclick="feedSuggest('{{ $word }}')">{{ $word }}</span>
            @endforeach
        </div>
    @endif
    <div id="keyboard-cont" style="touch-action: manipulation">
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
            <button class="keyboard-button">z</button>
            <button class="keyboard-button">c</button>
            <button class="keyboard-button">v</button>
            <button class="keyboard-button">b</button>
            <button class="keyboard-button">n</button>
            <button class="keyboard-button">m</button>
            <button class="keyboard-button">ö</button>
            <button class="keyboard-button">ç</button>
        </div>
        <div class="fourth-row mt-6" style="justify-content: space-evenly">
            <button class="keyboard-button del rounded-md">SİL</button>
            <button class="keyboard-button clear rounded-md">TEMİZLE</button>
            <button class="keyboard-button enter rounded-md">Enter</button>
        </div>
    </div>

{{--    <livewire:funny-sentence :word="$wordName"/>--}}
    @if($opponentName != "Günün Kelimesi")
        <livewire:chat-wire :gameId="$gameId" :gameType="1" :chatcode="$chatcode"/>
        <livewire:contact-wire :friend="$myOpp"/>
    @endif

    <script>

        let addedRow = {{ $length + 1 }};
        let words = @json( \App\Models\Word::pluck('name'));
        let guesses = @json($guessesArray);

        let chatMode = false;
        let keyActive = true;

        function activateDuello() {
            document.getElementById('duelloAlert').style.visibility = "visible";
            document.getElementById('duelloAlert').innerHTML = "Hamle sırası sende";
            document.getElementById('duelloAlert').classList.add('bg-red-500');
            document.getElementById('duelloAlert').classList.remove('bg-indigo-500');
            document.getElementById('keyboard-cont').style.display = "flex";
            keyActive = true;
        }

        function deactivateDuello() {
            document.getElementById('duelloAlert').style.visibility = "visible";
            document.getElementById('duelloAlert').innerHTML = "Rakibin hamlesi bekleniyor";
            document.getElementById('duelloAlert').classList.add('bg-indigo-500');
            document.getElementById('duelloAlert').classList.remove('bg-red-500');
            document.getElementById('keyboard-cont').style.display = "none";
            keyActive = false;
        }

        function normalGame() {
            document.getElementById('keyboard-cont').style.display = "flex";
            document.getElementById('duelloAlert').style.display = "none";
            keyActive = true;
        }

        function doldur(k) {
            Array.from(k).forEach(function (m) {
                addedLetter = String(m);
                insertAddedLetter(addedLetter, k);
            })
        }

        function feedSuggest(k){
            for (x = 0; x < 8; x++) {
                document.dispatchEvent(new KeyboardEvent("keyup", {'key': "Backspace"}))
            }
            Array.from(k).forEach(function (m){
                insertLetter(m)
            })
        }

        @if($isDuello == null)
        normalGame();
        @elseif($isDuello == 1 AND $sira == \Illuminate\Support\Facades\Auth::id())
        activateDuello();
        @elseif($isDuello == 1 AND $sira != \Illuminate\Support\Facades\Auth::id())
        deactivateDuello();
        @endif

        if (document.getElementById('chatInput')) {
            document.getElementById('chatInput').onfocus = function () {
                chatMode = true
            }
            document.getElementById('chatInput').onblur = function () {
                chatMode = false;
            }
        }

        const NUMBER_OF_GUESSES = {{ $length + 1 }};
        let guessesRemaining = NUMBER_OF_GUESSES;
        let currentGuess = [];
        let nextLetter = 0;
        let rightGuessString = "{{ $wordName }}";
        let waitSubmit = 0;

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
            if (chatMode === false && keyActive === true) {
                if (guessesRemaining === 0) {
                    return
                }

                let pressedKey = String(e.key)
                if (pressedKey === "Backspace" && nextLetter !== 0) {
                    deleteLetter()
                    return
                }

                if (pressedKey === "Enter") {
                    if (waitSubmit === 0) {
                        checkGuess()
                        waitSubmit = 1;
                        setTimeout(function () {
                            waitSubmit = 0;
                        }, 1500)
                    }
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
            console.log("onAddedGuess:")
            console.log({{ $length + 1 }} - a);
            let guessString = ''
            let rightGuess = Array.from(rightGuessString)

            for (const val of currentGuess) {
                guessString += val
            }

            let answer = [];
            for (let i = 0; i < {{ $length }}; i++) {
                let box = row.children[i]
                let letter = currentGuess[i];
                answer.push(letter);
                let letterColor = 'rgb(227, 227, 227)'
                if (rightGuess.includes(letter)) {
                    if (rightGuess[i] === letter) {
                        letterColor = 'rgb(2, 204, 9)'
                        if (count(currentGuess, letter) > count(rightGuess, letter)) {
                            for (let j = 0; j < {{ $length }}; j++) {
                                if (row.children[j].innerText == letter.toLocaleUpperCase('TR') && row.children[j].style.backgroundColor == 'rgb(255, 255, 0)') {
                                    row.children[j].style.backgroundColor = 'rgb(227, 227, 227)';
                                    let index = answer.indexOf(letter);
                                    if (index !== -1) {
                                        answer.splice(index, 1);
                                    }
                                }
                            }
                        }
                    } else {
                        if (countOccurrences(answer, letter) <= count(rightGuessString, letter)) {
                            letterColor = 'rgb(255, 255, 0)';
                        } else {
                            letterColor = 'rgb(227, 227, 227)';
                        }
                    }
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

        let wrongGuess = 0;

        function count(str, letter) {
            let count = 0;

            // looping through the items
            for (let i = 0; i < str.length; i++) {

                // check if the character is at that position
                if (str.toString().charAt(i) === letter) {
                    count += 1;
                }
            }
            return count;
        }

        function countOccurrences(arr, val) {
            let count = 0;
            for (i = 0; i < arr.length; i++) {
                if (arr[i] === val) {
                    count++;
                }
            }
            return count;
        }

        let isDuello = {{ $isDuello }};
        console.log("onLoad:")
        console.log(+{{ $length + 1 }} - guessesRemaining);

        function checkGuess() {
            let row = document.getElementsByClassName("letter-row")[{{ $length + 1 }} - guessesRemaining]
            console.log("onCheckGuess:")
            console.log({{ $length + 1 }} - guessesRemaining);
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
                wrongGuess += 1
                for (let i = 0; i < {{ $length }}; i++) {
                    let box = row.children[i]
                    box.classList.add("wrong-box")
                    box.classList.remove("filled-box")
                    let delay = 100 * i;
                    setTimeout(() => {
                        animateCSS(box, 'headShake')

                        box.classList.add("filled-box")
                        box.classList.remove("wrong-box")
                        //shade box
                    }, delay)

                }

                if (wrongGuess > 2 && isDuello === 1) {
                    let key = "Backspace";
                    for (let x = 0; x < 8; x++) {
                        document.dispatchEvent(new KeyboardEvent("keyup", {'key': key}))
                    }
                    notifyGame("3 defa hatalı kelime girdin, sıra karşıya geçti", "");
                    Livewire.emit('siraChange', {{ $gameId }}, 1);
                    deactivateDuello();
                }
                return
            }


            let answer = [];
            for (let i = 0; i < {{ $length }}; i++) {
                let box = row.children[i]
                let letter = currentGuess[i];
                answer.push(letter);
                let letterColor = 'rgb(227, 227, 227)'
                if (rightGuess.includes(letter)) {
                    if (rightGuess[i] === letter) {
                        letterColor = 'rgb(2, 204, 9)'
                        if (count(currentGuess, letter) > count(rightGuess, letter)) {
                            for (let j = 0; j < {{ $length }}; j++) {
                                if (row.children[j].innerText == letter.toLocaleUpperCase('TR') && row.children[j].style.backgroundColor == 'rgb(255, 255, 0)') {
                                    row.children[j].style.backgroundColor = 'rgb(227, 227, 227)';
                                    let index = answer.indexOf(letter);
                                    if (index !== -1) {
                                        answer.splice(index, 1);
                                    }
                                }
                            }
                        }
                    } else {
                        if (countOccurrences(answer, letter) <= count(rightGuessString, letter)) {
                            letterColor = 'rgb(255, 255, 0)';
                        } else {
                            letterColor = 'rgb(227, 227, 227)';
                        }
                    }
                }


                let delay = 70 * i
                setTimeout(() => {
                    animateCSS(box, 'flipInX')
                    //shade box
                }, delay)
                box.style.backgroundColor = letterColor
                shadeKeyBoard(letter, letterColor)
            }

            Livewire.emit('addGuess', guessString, {{ $gameId }}, isDuello);

            if (isDuello === 1) {
                deactivateDuello();
            }

            setTimeout(function () {
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
            }, 1000)

        }


        function checkGuess2(k) {
            let row = document.getElementsByClassName("letter-row")[{{ $length + 1 }} - guessesRemaining];
            let nad = 0;
            Array.from(k).forEach(function (m) {
                addedLetter = String(m)
                let box = row.children[nad];
                box.style.borderColor = "red";
                addedLetter = addedLetter.toLowerCase()
                box.textContent = addedLetter
                nad += 1
            })

            let guessString = ''
            let rightGuess = Array.from(rightGuessString)

            for (const val of currentGuess) {
                guessString += val
            }

            let answer = [];
            for (let i = 0; i < {{ $length }}; i++) {
                let box = row.children[i]
                let letter = currentGuess[i];
                answer.push(letter);
                let letterColor = 'rgb(227, 227, 227)'
                if (rightGuess.includes(letter)) {
                    if (rightGuess[i] === letter) {
                        letterColor = 'rgb(2, 204, 9)'
                        if (count(currentGuess, letter) > count(rightGuess, letter)) {
                            for (let j = 0; j < {{ $length }}; j++) {
                                if (row.children[j].innerText == letter.toLocaleUpperCase('TR') && row.children[j].style.backgroundColor == 'rgb(255, 255, 0)') {
                                    row.children[j].style.backgroundColor = 'rgb(227, 227, 227)';
                                    let index = answer.indexOf(letter);
                                    if (index !== -1) {
                                        answer.splice(index, 1);
                                    }
                                }
                            }
                        }
                    } else {
                        if (countOccurrences(answer, letter) <= count(rightGuessString, letter)) {
                            letterColor = 'rgb(255, 255, 0)';
                        } else {
                            letterColor = 'rgb(227, 227, 227)';
                        }
                    }
                }


                let delay = 70 * i
                setTimeout(() => {
                    animateCSS(box, 'flipInX')
                    //shade box
                }, delay)
                box.style.backgroundColor = letterColor
                shadeKeyBoard(letter, letterColor)
            }

            setTimeout(function () {
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
            }, 1000)

        }


        function shadeKeyBoard(letter, color) {
            for (const elem of document.getElementsByClassName("keyboard-button")) {
                if (elem.textContent === letter) {

                    let oldColor = elem.style.backgroundColor;

                    if (oldColor === 'rgb(2, 204, 9)') {
                        return
                    }

                    if (oldColor === 'rgb(255, 255, 0)' && color !== 'rgb(2, 204, 9)') {
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
