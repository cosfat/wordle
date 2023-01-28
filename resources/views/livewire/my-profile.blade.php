<div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                @livewire('profile.update-profile-information-form')

                <x-jet-section-border />
            @endif

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.update-password-form')
                </div>

                <x-jet-section-border />
            @endif

                <form class="mt-4" method="POST" action="{{ route('logout') }}" x-data>
                    @csrf

                    <x-jet-danger-button class="ml-2"  href="{{ route('logout') }}"
                                         @click.prevent="$root.submit();">
                        {{ __('Çıkış yap') }}
                    </x-jet-danger-button>
                </form>
        </div>

    @if (session()->has('message'))
        <script>
            notifyGame("{{  session('message')  }}")
        </script>
    @endif
    </div>
