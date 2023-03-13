<div>
    @include('loading')
{{--    @include('components.create.mainButtons')--}}
    <div class="flex justify-center">
        <h2 class="text-2xl font-bold tracking-tight sm:text-center sm:text-4xl text-indigo-500">
            YENİ OYUN BAŞLAT</h2>
    </div>
        <div class="flex justify-center mt-2">
            <h3><strong>Kaç harfli olsun?</strong></h3></div>
        <div class="flex justify-center mt-2">
            <h2 wire:click="changeLength(4)"
                class="@if($length == 4) bg-yellow-400 @else bg-gray-100 @endif border-2 px-4 py-2 cursor-pointer text-2xl font-bold tracking-tight sm:text-4xl sm:text-center text-indigo-500 ml-3"
                style="border-color: rgb(250, 204, 21);">4</h2>
            <h2 wire:click="changeLength(5)"
                class="@if($length == 5) bg-yellow-400 @else bg-gray-100 @endif border-2 px-4 py-2 cursor-pointer text-2xl font-bold tracking-tight sm:text-4xl sm:text-center text-indigo-500 ml-3"
                style="border-color: rgb(250, 204, 21);">5</h2>
            <h2 wire:click="changeLength(6)"
                class="@if($length == 6) bg-yellow-400 @else bg-gray-100 @endif border-2 px-4 py-2 cursor-pointer text-2xl font-bold tracking-tight sm:text-4xl sm:text-center text-indigo-500 ml-3"
                style="border-color: rgb(250, 204, 21);">6</h2>
            <h2 wire:click="changeLength(7)"
                class="@if($length == 7) bg-yellow-400 @else bg-gray-100 @endif border-2 px-4 py-2 cursor-pointer text-2xl font-bold tracking-tight sm:text-4xl sm:text-center text-indigo-500 ml-3"
                style="border-color: rgb(250, 204, 21);">7</h2>
        </div>

        <div class="flex justify-center mt-6">
            <h2 class="text-2xl font-bold tracking-tight sm:text-center sm:text-4xl text-indigo-500">
                OYUN MODU</h2>
        </div>

        <div class="flex justify-center mt-3 border-b pb-4">
            <button
                class="px-3 py-3 font-medium text-slate-700 shadow-xl @if($mode == 3) bg-yellow-400 @else bg-white @endif bg- duration-150"
                type="button" wire:click="$set('mode', 3)">
                Klasik
            </button>

            <button
                class="px-3 py-3 font-medium text-slate-700 shadow-xl @if($mode == 2) bg-yellow-400 @else bg-white @endif duration-150"
                type="button" wire:click="makeMode2">
                Rekabet
            </button>
            <button
                class="px-3 py-3 font-medium text-slate-700 shadow-xl @if($mode == 4) bg-yellow-400 @else bg-white @endif duration-150"
                type="button" wire:click="makeMode4">
                Düello
            </button>
            
            <button
                class="px-3 py-3 font-medium text-slate-700 shadow-xl @if($mode == 5) bg-yellow-400 @else bg-white @endif duration-150"
                type="button" wire:click="makeMode5">
                Solo
            </button>
            
        </div>

        @if($mode == 2)
            <form method="POST" action="#" wire:submit.prevent="test">
                <x-honeypot/>
                <div class="p-5 gap-2 border-b-2">
                    <div class="flex justify-center mt-3">
                        <h2>Seçtiğin arkadaşlarınla aynı kelimeyi bulmaya çalış</h2>
                    </div>
                    <div class="flex justify-center flex-wrap mt-3">
                        <button type="button"
                                class="mt-1 px-5 py-3 font-medium text-slate-700 shadow-xl duration-150 bg-yellow-400 ml-4">
                            {{ \Illuminate\Support\Facades\Auth::user()->username }}
                        </button>
                        @foreach($suggestChFriend as $friend)
                            <button type="button"
                                    class="mt-1 px-5 py-3 font-medium text-slate-700 shadow-xl duration-150 @if(array_search($friend, $challengeFriends)) bg-yellow-400 @else bg-white @endif"
                                    wire:click="addChallengeFriend('{{ $friend }}')" class="ml-4">

                                @if(\Illuminate\Support\Facades\Cache::has('user-is-online-' . \App\Models\User::where('username', $friend)->first()->id))
                                    <span style="background-color: chartreuse; height: 25px;
  width: 25px;
  border-radius: 50%;
  display: inline-block;">&nbsp;</span>
                                @else
                                    <span style="background-color: #494949 ; height: 25px;
  width: 25px;
  border-radius: 50%;
  display: inline-block;">&nbsp;</span>
                                @endif
                                {{ $friend }}
                            </button>
                        @endforeach
                    </div>

                    <div class="flex justify-center mt-6">
                        <h2>Aşağıdan kullanıcı adıyla da arkadaş ekleyebilirsin</h2>
                    </div>
                    <div class="flex justify-center mt-3">
                        <x-jet-input wire:model.defer="challengeUserName" placeholder="Kullanıcı adı"
                                     id="challengeUserName"
                                     class="mt-1"
                                     type="text" name="challengeUserName" value="{{ $challengeUserName }}"/>
                        <button type="button"
                                class="ml-2 px-5 py-3 font-medium text-slate-700 shadow-xl duration-150 bg-yellow-400"
                                wire:click="checkChallengeUsername()" class="ml-4">
                            {{ __('Gönder') }}
                        </button>

                        @if($chOpponentError)
                            @if($chExistingGameError)
                                <script>notifyGame('Bu kullanıcıyla tamamlanmamış bir rekabet oyunu var')</script>
                            @else
                                <script>notifyGame('Geçersiz kullanıcı')</script>
                            @endif
                        @endif
                    </div>

                    <div class="flex justify-center mt-6">
                        <h2>Veya rasgele oyuncu ekleyebilirsin</h2>
                    </div>
                    <div class="flex justify-center mt-3">
                        <button type="button"
                                class="mt-1 px-5 py-3 font-medium text-slate-700 shadow-xl duration-150 bg-yellow-400"
                                wire:click="autoChOpp()" class="ml-4">
                            {{ __('Rasgele rakip') }}
                        </button>
                    </div>

                    <div class="flex justify-center mt-3">
                        <h2>Oyun bitiminde aynı kişilerle yeni oyun başlatılsın mı?</h2>
                    </div>
                    <div class="flex justify-center mt-3">
                        <button type="button"
                                class="mt-1 px-5 py-3 font-medium text-slate-700 shadow-xl duration-150 @if($replay == 1) bg-yellow-400 @else bg-white @endif"
                                @if($replay == 1)
                                wire:click="$set('replay', 0)"
                                    @else
                                wire:click="$set('replay', 1)"
                                    @endif
                                 class="ml-4">
                            @if($replay == 1)
                                Otomatik başlatmayı kapat
                            @else
                                Otomatik başlatmayı aç
                            @endif
                        </button>
                    </div>
                    <div class="flex justify-center mt-3">
                        <button type="button"
                                class="mt-1 px-5 py-3 font-medium text-slate-700 shadow-xl duration-150 bg-yellow-400"
                                wire:click="startChallengeGame()" class="ml-4">
                            {{ __('Hazırsanız başlayalım!') }}
                        </button>
                    </div>
                    <div class="flex justify-center mt-3"><p>(Arkadaşlarına başlattığını haber vermeyi unutma!)</p>
                    </div>
                </div>

            </form>
            
            
            @elseif($mode==5)
             <div class="flex justify-center mt-3">
                        <button type="button"
                                class="mt-1 px-5 py-3 font-medium text-slate-700 shadow-xl duration-150 @if($replay == 1) bg-yellow-400 @else bg-white @endif"
                                @if($replay == 1)
                                wire:click="$set('replay', 0)"
                                    @else
                                wire:click="$set('replay', 1)"
                                    @endif
                                 class="ml-4">
                            @if($replay == 1)
                                Otomatik başlatmayı kapat
                            @else
                                Otomatik başlatmayı aç
                            @endif
                        </button>
                    </div>
                    <div class="flex justify-center mt-3">
                        <button type="button"
                                class="mt-1 px-5 py-3 font-medium text-slate-700 shadow-xl duration-150 bg-yellow-400"
                                wire:click="startChallengeGame()" class="ml-4">
                            {{ __('Hazırsanız başlayalım!') }}
                        </button>
                    </div>

        @elseif($mode == 3)
            <form method="POST" action="#" wire:submit.prevent="test">
                <x-honeypot/>
                <div class="p-5 border-b-2">
                    <div class="flex justify-center mt-3">
                        <x-jet-input wire:model.defer="word"
                                     placeholder="{{ $length }} harflik bir kelime yaz" id="word" class="mt-1"
                                     type="text"
                                     value="{{ $word }}" name="word" required autofocus/>

                        <button
                            class="ml-2 px-5 py-3 font-medium text-slate-700 shadow-xl duration-150 bg-yellow-400"
                            type="button" wire:click="checkWord()">
                            {{ __('Gönder') }}
                        </button>
                        @if ($wordError)
                            <script>notifyGame('Geçersiz kelime')</script>
                        @endif
                    </div>

                    @if($suggestBoxes)
                        <div class="flex justify-center mt-3">
                            @foreach($suggests as $suggest)
                                <button
                                    class="mt-1 px-3 py-3 font-medium text-slate-700 shadow-xl duration-150 @if($word == $suggest)) bg-yellow-400 @else bg-white @endif"
                                    type="button" wire:click="pickSuggest('{{ $suggest }}')">
                                    {{ $suggest }}
                                </button>

                            @endforeach
                        </div>
                    @endif

                    <div class="flex justify-center">
                        <button
                            class="mt-3 px-5 py-3 font-medium text-slate-700 shadow-xl duration-150 bg-yellow-400"
                            type="button" wire:click="autoWord()">
                            {{ __('Bana kelime öner') }}
                        </button>
                    </div>
                </div>
            </form>

            @if($hideOpponent == false)
                <form method="POST" action="#" wire:submit.prevent="test">
                    <x-honeypot/>
                    <div class="p-5 gap-2 border-b-2">
                        <div class="flex justify-center">
                            <h2 class="text-2xl font-bold tracking-tight sm:text-center sm:text-4xl text-indigo-500">
                                Rakip</h2>
                        </div>
                        <div class="flex justify-center mt-3">
                            <h2>Arkadaş önerileri</h2>
                        </div>
                        <div class="flex justify-center flex-wrap  mt-3">
                            @foreach($suggestFriend as $friend)
                                <button type="button"
                                        class="mt-1 px-5 py-3 font-medium text-slate-700 shadow-xl duration-150 @if($opponentUserName == $friend) bg-yellow-400 @else bg-white @endif"
                                        wire:click="$set('opponentUserName', '{{ $friend }}')" class="ml-4">
                                    {{ $friend }}
                                </button>
                            @endforeach
                        </div>

                        <div class="flex justify-center mt-6">
                            <h2>Başka bir kullanıcı bul</h2>
                        </div>
                        <div class="flex justify-center mt-3">
                            <x-jet-input wire:model.defer="opponentUserName" placeholder="Kullanıcı adı"
                                         id="opponentUserName"
                                         class="mt-1"
                                         type="text" name="opponentUserName" value="{{ $opponentUserName }}"/>
                            <button type="button"
                                    class="ml-2 px-5 py-3 font-medium text-slate-700 shadow-xl duration-150 bg-yellow-400"
                                    wire:click="checkEmail()" class="ml-4">
                                {{ __('Gönder') }}
                            </button>

                            @if($opponentError)
                                @if($existingGameError)
                                    <script>notifyGame('Bu kullanıcıya zaten oyun gönderdiniz')</script>
                                @else
                                    <script>notifyGame('Geçersiz kullanıcı')</script>
                                @endif
                            @endif
                        </div>

                        <div class="flex justify-center mt-6">
                            <h2>Rasgele oyuncu bul</h2>
                        </div>
                        <div class="flex justify-center mt-3">
                            <button type="button"
                                    class="mt-1 px-5 py-3 font-medium text-slate-700 shadow-xl duration-150 bg-yellow-400"
                                    wire:click="autoOpp()" class="ml-4">
                                {{ __('Rasgele rakip') }}
                            </button>
                        </div>
                    </div>

                </form>
            @endif
        @elseif($mode == 4)
            @if($hideOpponent == false)
                <form method="POST" action="#" wire:submit.prevent="test">
                    <x-honeypot/>
                    <div class="p-5 gap-2 border-b-2">
                        <div class="flex justify-center">
                            <h2 class="text-2xl font-bold tracking-tight sm:text-center sm:text-4xl text-indigo-500">
                                Rakip</h2>
                        </div>
                        <div class="flex justify-center mt-3">
                            <h2>Arkadaş önerileri</h2>
                        </div>
                        <div class="flex justify-center flex-wrap  mt-3">
                            @foreach($suggestFriend as $friend)
                                <button type="button"
                                        class="mt-1 px-5 py-3 font-medium text-slate-700 shadow-xl duration-150 @if($opponentUserName == $friend) bg-yellow-400 @else bg-white @endif"
                                        wire:click="$set('opponentUserName', '{{ $friend }}')" class="ml-4">
                                    {{ $friend }}

                                </button>
                            @endforeach
                        </div>

                        <div class="flex justify-center mt-6">
                            <h2>Başka bir kullanıcı bul</h2>
                        </div>
                        <div class="flex justify-center mt-3">
                            <x-jet-input wire:model.defer="opponentUserName" placeholder="Kullanıcı adı"
                                         id="opponentUserName"
                                         class="mt-1"
                                         type="text" name="opponentUserName" value="{{ $opponentUserName }}"/>
                            <button type="button"
                                    class="ml-2 px-5 py-3 font-medium text-slate-700 shadow-xl duration-150 bg-yellow-400"
                                    wire:click="checkEmail()" class="ml-4">
                                {{ __('Gönder') }}
                            </button>

                            @if($opponentError)
                                @if($existingGameError)
                                    <script>notifyGame('Bu kullanıcıya zaten oyun gönderdiniz')</script>
                                @else
                                    <script>notifyGame('Geçersiz kullanıcı')</script>
                                @endif
                            @endif
                        </div>
                    </div>
                </form>
            @endif
        @endif
        @if (session()->has('message'))
            <script>
                notifyGame("{{  session('message')  }}")
            </script>
        @endif
</div>
