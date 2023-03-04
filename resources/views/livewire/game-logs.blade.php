<div class="gap-2 container mx-auto rounded-lg bg-gray-200">
    <link rel="stylesheet" href="/css/swiper.css">
    @vite(['resources/css/scss.scss'])
    <div class="swiper-container">
        <!-- Add Pagination -->
        <div class="swiper-pagination">
        </div>
        <div class="swiper-wrapper">
            <div class="swiper-slide"><ul style="margin-top: 40px" class="p-2 w-full text-left text-sm font-medium text-white rounded-lg">
                    @foreach($notesCh as $note)
                        <a href="/finished-challenge-game-watcher/{{ $note['link'] }}">
                            @if($note['status'] == 1)

                                <li class="w-full py-2 bg-gray-200 text-gray-600"><strong>{{ $note['user'] }}</strong>
                                    <strong>{{ $note['word'] }}</strong>
                                    <span
                                        class="bg-red-600 text-white text-xs font-medium px-2 py-1 rounded">{{ $note['duration'] }}</span>
                                    <span class="bg-green-600 text-white text-xs font-medium  px-2 py-1 rounded">{{ $note['point'] }} p</span>
                            @elseif($note['status']==2)

                                <li class="w-full py-2 bg-gray-200 text-gray-600"><strong>{{ $note['user'] }}</strong>
                                    <strong>{{ $note['word'] }}</strong>
                                    <span
                                        class="bg-red-600 text-white text-xs font-medium px-2 py-1 rounded">{{ $note['duration'] }}</span>
                                    <span class="bg-green-600 text-white text-xs font-medium  px-2 py-1 rounded">{{ $note['point'] }} p</span>
                            @else
                                <li class="w-full py-2 text-white-500 bg-gray-800">{{ $note['user'] }}:
                                    <strong>{{ $note['word'] }}</strong>
                                    @endif

                                    @if($note['chat'])
                                        <svg class="float-right mr-3" width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg" stroke="#EF4444">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                               stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <path opacity="0.4" d="M8.5 10.5H15.5" stroke="#faccc15" stroke-width="1.5"
                                                      stroke-miterlimit="10" stroke-linecap="round"
                                                      stroke-linejoin="round"></path>
                                                <path
                                                    d="M7 18.4302H11L15.45 21.3902C16.11 21.8302 17 21.3602 17 20.5602V18.4302C20 18.4302 22 16.4302 22 13.4302V7.43018C22 4.43018 20 2.43018 17 2.43018H7C4 2.43018 2 4.43018 2 7.43018V13.4302C2 16.4302 4 18.4302 7 18.4302Z"
                                                    stroke="#facc15" stroke-width="1.5" stroke-miterlimit="10"
                                                    stroke-linecap="round" stroke-linejoin="round"></path>
                                            </g>
                                        </svg>
                                    @endif
                                </li>
                        </a>
                    @endforeach
                </ul>
            </div>
            <div class="swiper-slide"><ul style="margin-top: 40px" class="p-2 w-full text-left text-sm font-medium text-white rounded-lg">
                    @foreach($notes as $note)
                        <a href="/finished-game-watcher/{{ $note['link'] }}">
                            <li class="w-full py-2 text-gray-600 bg-gray-200">{{ $note['user'] }}
                                @if($note['status'] == 1)
                                    <strong>{{ $note['word'] }}</strong>
                                    <span
                                        class="bg-red-600 text-white text-xs font-medium  px-2 py-1 rounded">{{ $note['duration'] }}</span>
                                    <span
                                        class="bg-yellow-400 text-indigo-700 text-xs font-medium  px-2 py-1 rounded"><strong>{{ $note['count'] }}</strong> t</span>
                                @else
                                    <strong>{{ $note['word'] }}</strong>
                                    <span
                                        class="bg-red-600 text-white text-xs font-medium  px-2 py-1 rounded">{{ $note['duration'] }}</span>
                                @endif
                                @if($note['status'] == 1)
                                    <span class="bg-green-600 text-white text-xs font-medium  px-2 py-1 rounded">{{ $note['point'] }} p</span>
                                @else
                                    <span
                                        class="bg-gray-800 text-white text-xs font-medium  px-2 py-1 rounded">Kaybetti</span>
                                @endif
                                @if($note['chat'])
                                    <svg class="float-right mr-3" width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                                         xmlns="http://www.w3.org/2000/svg" stroke="#EF4444">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path opacity="0.4" d="M8.5 10.5H15.5" stroke="#facc15" stroke-width="1.5"
                                                  stroke-miterlimit="10" stroke-linecap="round"
                                                  stroke-linejoin="round"></path>
                                            <path
                                                d="M7 18.4302H11L15.45 21.3902C16.11 21.8302 17 21.3602 17 20.5602V18.4302C20 18.4302 22 16.4302 22 13.4302V7.43018C22 4.43018 20 2.43018 17 2.43018H7C4 2.43018 2 4.43018 2 7.43018V13.4302C2 16.4302 4 18.4302 7 18.4302Z"
                                                stroke="#facc15" stroke-width="1.5" stroke-miterlimit="10"
                                                stroke-linecap="round" stroke-linejoin="round"></path>
                                        </g>
                                    </svg>
                                @endif
                                @if($note['isDuello'] == 1)
                                    (düello)
                                @endif
                            </li>
                        </a>
                    @endforeach
                </ul></div>
            <div class="swiper-slide"><ul style="margin-top: 40px" class="p-2 w-full text-left text-sm font-medium text-white rounded-lg">
                    @foreach($notesMe as $note)
                        <a href="/finished-game-watcher/{{ $note['link'] }}">
                            <li class="w-full py-2 text-gray-600 bg-gray-200">{{ $note['user'] }}:
                                @if($note['status'] == 1)
                                    <strong>{{ $note['word'] }}</strong>
                                    <span
                                        class="bg-red-600 text-white text-xs font-medium  px-2 py-1 rounded">{{ $note['duration'] }}</span>
                                    <span
                                        class="bg-yellow-400 text-indigo-700 text-xs font-medium  px-2 py-1 rounded"><strong>{{ $note['count'] }}</strong> t</span>
                                    <span class="bg-green-600 text-white text-xs font-medium  px-2 py-1 rounded">{{ $note['point'] }} p</span>
                                @else
                                    <strong>{{ $note['word'] }}</strong>
                                    <span
                                        class="bg-red-600 text-white text-xs font-medium  px-2 py-1 rounded">{{ $note['duration'] }}</span>
                                    <span
                                        class="bg-gray-800 text-white text-xs font-medium  px-2 py-1 rounded">Bilemedin</span>
                                @endif
                                @if($note['chat'])
                                    <svg class="float-right mr-3" width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                                         xmlns="http://www.w3.org/2000/svg" stroke="#EF4444">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path opacity="0.4" d="M8.5 10.5H15.5" stroke="#facc15" stroke-width="1.5"
                                                  stroke-miterlimit="10" stroke-linecap="round"
                                                  stroke-linejoin="round"></path>
                                            <path
                                                d="M7 18.4302H11L15.45 21.3902C16.11 21.8302 17 21.3602 17 20.5602V18.4302C20 18.4302 22 16.4302 22 13.4302V7.43018C22 4.43018 20 2.43018 17 2.43018H7C4 2.43018 2 4.43018 2 7.43018V13.4302C2 16.4302 4 18.4302 7 18.4302Z"
                                                stroke="#facc15" stroke-width="1.5" stroke-miterlimit="10"
                                                stroke-linecap="round" stroke-linejoin="round"></path>
                                        </g>
                                    </svg>
                                @endif
                                @if($note['isDuello'] == 1)
                                    (düello)
                                @endif
                            </li>
                        </a>
                    @endforeach
                </ul></div>
        </div>
    </div>
    <script src="/js/swiper.js"></script>
    <script>
        var swiper = new Swiper('.swiper-container', {
            pagination: '.swiper-pagination',
            slidesPerView: 1,
            paginationClickable: true,
            loop: true,
            paginationBulletRender: function (index, className) {
                var tabsName = ['Rekabetler', 'Sorduklarım', 'Çözdüklerim'];
                if ( index === (tabsName.length - 1) ) {
                    return	'<span class="' + className + '">'
                        + tabsName[index] + '</span>'
                        + '<div class="active-mark "></div>';
                }
                return '<span class="' + className + '">' + tabsName[index] + '</span>';
            }
        });
    </script>
</div>
