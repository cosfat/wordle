<style>
    .makeAppImages {
        display: none;
        border: 10px solid #4F46E5;
        margin: 10px;
        width: 60%;
        cursor: pointer;
    }
</style>
<div id="m1"
     class="flex w-full bg-yellow-400 cursor-pointer text-indigo-700 font-bold p-2 justify-between"
     style="margin-top: -12px"><span onclick="show1()">iPhone'a indir</span> <span onclick="show1a()">Android'e indir</span>
</div>
<div class="flex justify-center">
    <img class="makeAppImages" id="m2" onclick="show2()" src="/images/makeApp/1.jpg">
    <img class="makeAppImages" id="m3" onclick="show3()" src="/images/makeApp/2.jpg">
    <img class="makeAppImages" id="m4" onclick="show4()" src="/images/makeApp/3.jpg">
    <img class="makeAppImages" id="m5" onclick="stopApp()" src="/images/makeApp/4.jpg">

    <img class="makeAppImages" id="m2a" onclick="show2a()" src="/images/makeApp/1a.jpg">
    <img class="makeAppImages" id="m3a" onclick="show3a()" src="/images/makeApp/2a.jpg">
    <img class="makeAppImages" id="m4a" onclick="stopAppa()" src="/images/makeApp/3a.jpg">
</div>
<script>
    function show1() {
        document.getElementById('m2').style = 'display: block';
    }

    function show2() {
        document.getElementById('m3').style = 'display: block';
        document.getElementById('m2').style = 'display: none';
    }

    function show3() {
        document.getElementById('m4').style = 'display: block';
        document.getElementById('m3').style = 'display: none';
    }

    function show4() {
        document.getElementById('m5').style = 'display: block';
        document.getElementById('m4').style = 'display: none';
    }

    function stopApp() {
        document.getElementById('m2').style = 'display: none';
        document.getElementById('m3').style = 'display: none';
        document.getElementById('m4').style = 'display: none';
        document.getElementById('m5').style = 'display: none';
    }

    function show1a() {
        document.getElementById('m2a').style = 'display: block';
    }

    function show2a() {
        document.getElementById('m3a').style = 'display: block';
        document.getElementById('m2a').style = 'display: none';
    }

    function show3a() {
        document.getElementById('m4a').style = 'display: block';
        document.getElementById('m3a').style = 'display: none';
    }
    function stopAppa() {
        document.getElementById('m2a').style = 'display: none';
        document.getElementById('m3a').style = 'display: none';
        document.getElementById('m4a').style = 'display: none';
    }
</script>
