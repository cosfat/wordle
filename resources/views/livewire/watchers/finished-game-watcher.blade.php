<div name="finished-game-watcher">
    @include('loading')
    <div class="flex justify-center">
        @if($opponentName == "Günün Kelimesi")
            <h2 class="text-2xl font-bold tracking-tight sm:text-center sm:text-4xl text-indigo-500">{{ $opponentName }}</h2>
        @else
            <a href="/user-summary/{{ \App\Models\User::where('username', $opponentName)->first()->id }}">
                <h2 class="text-2xl font-bold tracking-tight sm:text-center sm:text-4xl text-indigo-500">{{ $opponentName }}</h2>
            </a>
        @endif
        <svg version="1.1" id="Uploaded to svgrepo.com" xmlns="http://www.w3.org/2000/svg"
             xmlns:xlink="http://www.w3.org/1999/xlink" width="48px" height="48px" viewBox="0 0 32 32"
             xml:space="preserve" fill="#FACC15"><g id="SVGRepo_bgCarrier" stroke-width="0"></g>
            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
            <g id="SVGRepo_iconCarrier">
                <style type="text/css"> .linesandangles_een {
                        fill: #FACC15;
                    } </style>
                <path class="linesandangles_een"
                      d="M28.414,24l-3-3l2.293-2.293l-1.414-1.414l-2.236,2.236l-3.588-4.186L25,11.46V6h-5.46L16,10.13 L12.46,6H7v5.46l4.531,3.884l-3.588,4.186l-2.236-2.236l-1.414,1.414L6.586,21l-3,3L7,27.414l3-3l2.293,2.293l1.414-1.414 l-2.237-2.237L16,19.174l4.53,3.882l-2.237,2.237l1.414,1.414L22,24.414l3,3L28.414,24z M6.414,24L8,22.414L8.586,23L7,24.586 L6.414,24z M9,10.54V8h2.54l3.143,3.667l-1.85,2.159L9,10.54z M20.46,8H23v2.54L10.053,21.638l-0.69-0.69L20.46,8z M18.95,16.645 l3.688,4.302l-0.69,0.69l-4.411-3.781L18.95,16.645z M25,24.586L23.414,23L24,22.414L25.586,24L25,24.586z"></path>
            </g></svg>
        <h2 class="text-2xl font-bold tracking-tight sm:text-center sm:text-4xl text-indigo-500">
            <a href="/user-summary/{{ \App\Models\User::where('username', $userName)->first()->id }}">{{ $userName }}</a>
        </h2>
            </div>

    @if($todayRank != null)
    <div class="flex justify-center">
                <span class="text-green-600 text-sm">
        Sıralamada: {{ $todayRank }}
                </span>
    </div>
    @endif
    <div class="flex justify-center">
        <h2 class="text-2xl font-bold tracking-tight sm:text-center sm:text-4xl text-red-600">{{ $wordName }}</h2>
    </div>
    <div class="flex justify-center px-4">
        <span class="text-sm">"{{ $meaning }}"</span>
    </div>
    <div class="flex justify-center px-4">
        <span class="text-sm text-gray-600">{{ \App\Models\Game::find($gameId)->created_at->diffForHumans() }} - <strong>{{ $point }} puan -
            {{ $duration }}
            </strong></span>
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <div id="game-board">
    </div>
    @if($chat)
        <livewire:chat-wire :gameId="$gameId" :gameType="$gameType" :chatcode="$chatcode"/>
        <livewire:contact-wire :friend="$myOpp" />
    @elseif($myOpp)
        <livewire:contact-wire :friend="$myOpp" />
    @endif
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
                        letterColor = '#02cc09'
                        if(count(currentGuess, letter) > count(rightGuess, letter)){
                            for(let j = 0; j < {{ $length }}; j++){
                                console.log(row.children[j].innerText);
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
                notifyGame("{{ $winner }} kelimeyi bildi!")
                guessesRemaining = 0
                return
            } else {
                guessesRemaining -= 1;
                currentGuess = [];
                nextLetter = 0;

                @if($isDuello == 1)
                if (guessesRemaining === 0) {
                    notifyGame(`Kimse kazanamadı`)
                }
                @else
                if (guessesRemaining === 0) {
                    notifyGame(`{{ $userName }} kelimeyi bilemedi`)
                }
                @endif
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
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"
            integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
</div>
