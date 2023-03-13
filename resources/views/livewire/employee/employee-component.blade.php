<div>
    {{-- Be like water. --}}
    <div class="h-full overflow-y-auto px-6">
        <div class="ml-12 md:ml-0 my-6 text-2xl font-semibold text-stone-700">
            Employee
        </div>

        <div class="flex space-x-6 text-sm font-bold text-stone-500 border-b border-stone-200 tracking-wide">
            <a wire:click="page('lists')" class="{{ $page_name == 'lists'? 'border-b-2 border-red-400': '' }} py-1 px-4 cursor-pointer">
                Employee Lists
            </a>
            <a wire:click="page('archives')" class="{{ $page_name == 'archives'? 'border-b-2 border-red-400': '' }} py-1 px-4 cursor-pointer">
                Archives
            </a>
        </div>

        <div class="my-6">
            
            @if($page_name == "lists")
                @livewire('employee.lists-component')
            @elseif($page_name == "archives")
                @livewire('employee.archive-component')
            @endif
        </div>

    </div>
</div>
