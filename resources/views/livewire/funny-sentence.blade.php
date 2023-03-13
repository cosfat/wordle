<div class="flex justify-center mt-2">
    <button
        class="px-3 py-3 font-medium text-sm text-slate-700 shadow-xl bg-yellow-400 bg- duration-150 rounded-md"
        type="button"
        wire:click="$set('readyToLoad', true)">
        @if($readyToLoad)
            {{ $funnyText }} <br> Yeni ipucu için tıkla <br> <strong>({{ $credit }})</strong>
        @else
            Bana ipucu ver <strong>({{ $credit }})</strong>
        @endif
    </button>
    <div wire:loading>
        @include('loading')
    </div>
</div>
