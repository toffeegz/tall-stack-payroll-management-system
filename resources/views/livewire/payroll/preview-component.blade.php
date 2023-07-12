<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    <div class="h-full overflow-y-auto px-6 md:px-32">
        <div class="ml-12 md:ml-0 my-5 flex justify-between">
            <div class="text-2xl font-semibold text-stone-700">
                Run Payroll 
            </div>
            <div class="text-sm text-stone-500">
                Pay period: 
                {{ Carbon\Carbon::parse($payroll_period_start)->format('m/d/Y') . " - " . Carbon\Carbon::parse($payroll_period_end)->format('m/d/Y') }}
            </div>
        </div>

        {{-- Table header --}}
        <div class="flex justify-between my-4 space-x-4">
            <div class="flex justify-between space-x-4">
                <div class="md:w-72">
                    <x-forms.search-input placeholder="search employee name" name="search_employee_payroll"/>
                </div>
                <button wire:click="searchPayroll" class="bg-stone-500 text-white text-xs font-semibold  space-x-2 rounded-md px-4 flex items-center justify-center">
                    <i class="fa-solid fa-magnifying-glass fa-sm"></i><span>Search</span>
                </button>
            </div>
            <div class="space-x-2">
            </div>
        </div>

        {{-- Employee Table --}}
        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left text-stone-500 uppercase border-b ">
                            <th class="px-2 md:px-4 py-3 text-center">Employee</th>
                            <th class="px-2 md:px-4 py-3 text-center">Total Hours</th>
                            <th class="px-2 md:px-4 py-3 text-center"><span class="hidden md:inline-table">Additional</span> Earnings</th>
                            <th class="px-2 md:px-4 py-3 text-center">Deductions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y">
                        
                    </tbody>
                </table>
            </div>
            {{--  --}}
            <div class="w-full py-4 flex justify-between border-t border-stone-200">
                <div class="text-stone-500 text-sm font-semibold"> 
                    <!-- Last Saved: {{ $timestamp_saved_payroll }} -->
                </div>
                <div class="flex justify-end space-x-2 ">
                    <x-forms.button-rounded-md-secondary wire:click="saveForLater" wire:loading.attr="disabled">
                        Save for Later
                    </x-forms.button-rounded-md-secondary>
                    <x-forms.button-rounded-md-primary wire:click="submit" wire:loading.attr="disabled">
                        Proceed
                    </x-forms.button-rounded-md-primary>
                </div>
            </div>
        </div>
    </div>
</div>
