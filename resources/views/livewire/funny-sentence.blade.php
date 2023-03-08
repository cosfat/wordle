<div class="flex justify-center mt-2">
    <button
        class="px-3 py-3 font-medium text-slate-700 shadow-xl bg-yellow-400 bg- duration-150"
        type="button"
        wire:click="$set('readyToLoad', true)">
        @if($readyToLoad)
        {{ $funnyText }} <br> (Kalan: <strong>{{ $credit }}</strong>) <br> Yeni ipucu için tıkla
        @else
            Bana ipucu ver (İpucu hakkın: <strong>{{ $credit }}</strong>)
        @endif
    </button>
    <div wire:loading>
                @include('loading')
            </div>
</div>