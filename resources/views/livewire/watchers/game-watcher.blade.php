<div name="the-game">
    @include('loading')
    <div class="flex justify-center">
        <a href="/user-summary/{{ \App\Models\User::where('username', $opponentName)->first()->id }}">
        <h2 class="text-2xl font-bold tracking-tight sm:text-center sm:text-4xl text-indigo-500">{{ $opponentName }}: </h2></a>
        <h2 class="ml-3 text-2xl font-bold tracking-tight sm:text-center sm:text-4xl text-red-600"> {{ $wordName }}</h2>
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

    <div class="flex justify-center px-4 mt-2">
        <span class="text-sm text-gray-600">"{{ $meaning }}"</span>
    </div>

    <div class="flex justify-center mt-2">
        <h2>Son tahmin: {{ $lastGuessTime }}</h2>
    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <div id="game-board">
    </div>
    <livewire:chat-wire :opponentName="$opponentName" :gameId="$gameId" :gameType="1" />
    <livewire:contact-wire :friend="$myOpp" />
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
                let letterColor = 'rgb(227, 227, 227)'
                if(rightGuess.includes(letter)){
                    if(rightGuess[i] === letter){
                        letterColor = 'rgb(2, 204, 9)'
                        console.log(count(currentGuess,"i") + "-" +  count(rightGuess, "i"))
                        if(count(currentGuess, letter) > count(rightGuess, letter)){
                            console.log("xxx");
                            for(let j = 0; j < {{ $length }}; j++){
                                if(row.children[j].innerText == letter.toLocaleUpperCase('TR') && row.children[j].style.backgroundColor == 'rgb(255, 255, 0)'){
                                    row.children[j].style.backgroundColor = 'rgb(227, 227, 227)';
                                    let index = answer.indexOf(letter);
                                    if (index !== -1) {
                                        answer.splice(index, 1);
                                    }
                                }
                            }
                        }
                    }else{

                        if(countOccurrences(answer, letter) <= count(rightGuessString, letter)){
                            letterColor = 'rgb(255, 255, 0)';
                        }
                        else{
                            letterColor = 'rgb(227, 227, 227)';
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



        function shadeKeyBoard(letter, color) {
            for (const elem of document.getElementsByClassName("keyboard-button")) {
                if (elem.textContent === letter) {
                    let oldColor = elem.style.backgroundColor
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
