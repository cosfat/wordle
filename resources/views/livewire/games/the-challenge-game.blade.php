<div name="the-challenge-game">
    @include('loading')
    <div class="flex flex-wrap mb-4" style="padding: 0 60px 0 60px">
        @foreach($opponents as $key => $opponent)
        <a id="{{ $key }}" href="/user-summary/{{ \App\Models\User::where('username', $opponent)->first()->id }}">
            <h2 class="mr-2 text-sm font-bold tracking-tight sm:text-center sm:text-4xl @if(\Illuminate\Support\Facades\Cache::has('user-is-online-' . \App\Models\User::where('username', $opponent)->first()->id)) text-green-600 @else text-gray-500 @endif">{{ $opponent }}</h2>
        </a>
        @endforeach
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>

    </style>
    <livewire:games.live-counter :start="$start" :firstGuess="$firstGuess"></livewire:games.live-counter>
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
    <livewire:chat-wire :gameId="$gameId" :gameType="2" />
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
        let rightGuessString = "{{ \App\Models\Challenge::find($gameId)->word->name }}";
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
            if(chatMode === false) {
                if (guessesRemaining === 0) {
                    return
                }

                let pressedKey = String(e.key)
                if (pressedKey === "Backspace" && nextLetter !== 0) {
                    deleteLetter()
                    return
                }

                if (pressedKey === "Enter") {
                    if(waitSubmit === 0){
                    checkGuess()
                    waitSubmit = 1;
                    setTimeout(function (){
                        waitSubmit = 0;
                    }, 1500)
                }
                    return
                }

                let found = pressedKey.match(/[a-zöçşığü]/gi)
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
        function checkAddedGuess (a) {
            let row = document.getElementsByClassName("letter-row")[{{ $length + 1 }} - a]
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
                let letterColor = '#e3e3e3'
                if(rightGuess.includes(letter)){
                    if(rightGuess[i] === letter){
                        letterColor = '#02cc09'
                        if(count(currentGuess, letter) > count(rightGuess, letter)){
                            for(let j = 0; j < {{ $length }}; j++){
                                if(row.children[j].innerText == letter.toLocaleUpperCase('TR') && row.children[j].style.backgroundColor == 'yellow'){
                                    row.children[j].style.backgroundColor = '#e3e3e3';
                                    let index = answer.indexOf(letter);
                                    if (index !== -1) {
                                        answer.splice(index, 1);
                                    }
                                }
                            }
                        }
                    }else{
                        if(countOccurrences(answer, letter) <= count(rightGuessString, letter)){
                            letterColor = 'yellow';
                        }
                        else{
                            letterColor = '#e3e3e3';
                        }
                    }
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

            let answer = [];
            for (let i = 0; i < {{ $length }}; i++) {
                let box = row.children[i]
                let letter = currentGuess[i];
                answer.push(letter);
                let letterColor = '#e3e3e3'
                if(rightGuess.includes(letter)){
                    if(rightGuess[i] === letter){
                        letterColor = '#02cc09'
                        if(count(currentGuess, letter) > count(rightGuess, letter)){
                            for(let j = 0; j < {{ $length }}; j++){
                                console.log(row.children[j].innerText);
                                if(row.children[j].innerText == letter.toLocaleUpperCase('TR') && row.children[j].style.backgroundColor == 'yellow'){
                                    row.children[j].style.backgroundColor = '#e3e3e3';
                                    let index = answer.indexOf(letter);
                                    if (index !== -1) {
                                        answer.splice(index, 1);
                                    }
                                }
                            }
                        }
                    }else{
                        if(countOccurrences(answer, letter) <= count(rightGuessString, letter)){
                            letterColor = 'yellow';
                        }
                        else{
                            letterColor = '#e3e3e3';
                        }
                    }
                }

                let delay = 50 * i
                setTimeout(() => {
                    animateCSS(box, 'flipInX')
                    //shade box
                }, delay)

                box.style.backgroundColor = letterColor
                shadeKeyBoard(letter, letterColor)
            }

            let wordNumber = {{ $length + 1 }} - guessesRemaining;

            Livewire.emit('addChGuess', guessString, {{ $gameId }});

            setTimeout(function (){
                if (guessString === rightGuessString) {
                    Livewire.emit('chWinner');
                    notifyGame("Tebrikler!")
                    guessesRemaining = 0;
                    return
                } else {
                    guessesRemaining -= 1;
                    currentGuess = [];
                    nextLetter = 0;

                    if (guessesRemaining === 0) {
                        notifyGame(`Kaybettin! Doğru kelime: ${rightGuessString}`);
                        Livewire.emit('chLoser');
                    }
                }
            }, 1000)
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
