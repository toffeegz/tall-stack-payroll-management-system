<div>
    {{-- Be like water. --}}
    <div class="h-full overflow-y-auto px-6 md:px-36">
        <div class="ml-12 md:ml-0 my-12 text-2xl font-semibold text-stone-700">
            Settings
        </div>

        <div class="flex space-x-6 text-sm font-bold text-stone-500 border-b border-stone-200 tracking-wide">
            <a wire:click="page('company_information')" class="{{ $page_name == 'company_information'? 'border-b-2 border-red-400': '' }} py-1 px-4 cursor-pointer">
                Company Information
            </a>
            <a wire:click="page('leave_holidays')" class="{{ $page_name == 'leave_holidays'? 'border-b-2 border-red-400': '' }} py-1 px-4 cursor-pointer">
                Leave & Holidays
            </a>
            <a wire:click="page('tax_contribution_table')" class="{{ $page_name == 'tax_contribution_table'? 'border-b-2 border-red-400': '' }} py-1 px-4 cursor-pointer">
                Contribution Table
            </a>
        </div>

        <div class="my-6">
            
            @if($page_name == "company_information")
                @livewire('settings.company-information-component')
            @elseif($page_name == "leave_holidays")
                @livewire('settings.leave-holiday-component')
            @elseif($page_name == "tax_contribution_table")
                @livewire('settings.tax-contribution-component')
            @endif
        </div>

    </div>

    @include('scripts.settings.leave-holiday-script')
    @include('scripts.settings.company-information-script')

</div>
