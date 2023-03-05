<div class="mt-4 flex justify-center">
    <div class="cursor-pointer flex justify-center px-5 py-3 font-medium text-slate-700 shadow-xl @if($isContact == 1) text-white bg-red-500 @else bg-yellow-400 @endif "wire:click="state">
        {{ $message }}
    </div>
</div>
