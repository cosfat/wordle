<div class="counter">
    <div class="flex justify-center mb-2">
        @if($counting)
            <script>
                setInterval(function () {
                    showTime();
                }, 1000)
            </script>
            <span id="timer" class="bg-red-600 text-white font-medium px-2 py-1 rounded">ZAMAN</span>
        @endif
    </div>

    <script>
        let d = {{ $d }};
        let h = {{ $h }};
        let m = {{ $m }};
        let s = {{ $s }};

        function showTime() {
            s += 1;
            if (s > 59) {
                s = 0;
                m += 1;
            }

            if (m > 59) {
                m = 0
                h = h + 1;
            }

            if (h > 23) {
                h = 0
                d = d + 1;
            }
            let day = d;
            if(d === 0){
                day = "";
            }
            else {
                day = d + " gün";
            }
            let hour = h;
            let minute = m;
            let second = s;
            if (h < 10) {
                hour = "0" + hour;
            }
            if (m < 10) {
                minute = "0" + minute;
            }
            if (s < 10) {
                second = "0" + second;
            }
            let time = day + " " + hour + ":" + minute + ":" + second;
            document.getElementById("timer").innerText = time;
            document.getElementById("timer").textContent = time;
        }
    </script>
</div>
