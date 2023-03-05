<div class="mt-4 flex justify-center">
    <div class="cursor-pointer flex justify-center px-5 py-3 font-medium text-slate-700 shadow-xl @if($isContact == 1) bg-yellow-400 @else bg-white @endif "wire:click="state">
        {{ $message }}
    </div>
</div>
