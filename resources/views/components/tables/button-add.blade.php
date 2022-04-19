<!-- He who is contented is rich. - Laozi -->
{{-- add earnings --}}
<button type="button" class="text-blue-500 flex whitespace-nowrap" wire:click="{{ $wire }}">
    <div class="flex justify-center items-center">
        <i class="fa-solid fa-circle-plus"></i>
    </div>
    <p class="ml-1 text-xs">{{ $slot }}</p>
</button>