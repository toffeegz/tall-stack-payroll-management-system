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
                    <x-forms.search-input placeholder="search employee name" name="search"/>
                </div>
                <!-- <button wire:click="searchPayroll" class="bg-stone-500 text-white text-xs font-semibold  space-x-2 rounded-md px-4 flex items-center justify-center">
                    <i class="fa-solid fa-magnifying-glass fa-sm"></i><span>Search</span>
                </button> -->
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
                        @foreach($collection as $data)

                            @if($data['is_visible'] === true) 
                                <tr class="">
                                    {{-- employee --}}
                                    <td class="px-2 md:px-4 py-3 align-top space-y-2 w-56">
                                        
                                        <div class="flex space-x-4">
                                            <input type="checkbox" wire:model="collection.{{ $data['user_id'] }}.include_in_payroll" class="form-checkbox h-4 w-4 text-stone-500 rounded-sm border border-gray-300 p-1 text-stone-500 focus:ring-stone-500">
                                            <p class="text-stone-900 font-bold space-x-2 text-sm">{{ $data['name'] }} <span class="text-stone-500 font-semibold text-xs">({{ $data['code'] }})</span></p>
                                        </div>
                                        
                                        <div class="px-8 space-y-2">
                                            <p class="text-xs font-bold text-stone-700">Daily Rate</p>
                                            <div class=" space-y-2 w-52 ">
                                                @foreach ($data['rates_range'] as $range)
                                                    <div class="flex justify-between">
                                                        <div class="text-xs font-semibold text-stone-500">
                                                        {{ \Carbon\Carbon::parse($range['from'])->format('m/d') }}
                                                            - {{ \Carbon\Carbon::parse($range['to'])->format('m/d') }}
                                                        </div>
                                                        <div class="text-xs font-bold text-stone-700">
                                                        ₱{{ $range['rate'] }}
                                                        </div> 
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </td>
                                    <!-- total hours -->
                                    {{-- total hours --}}
                                    <td class="px-2 md:px-4 py-3 text-sm space-y-2  align-top text-center">
                                        @foreach($data['total_hours'] as $key => $total_hours)
                                            @if($total_hours['visible'] == true)
                                            <div class="flex justify-between w-28 md:w-40 mx-auto">
                                                <div class="flex items-center justify-between">
                                                    <div class="text-xs font-semibold text-stone-500 w-20 md:w-26">
                                                        {{ $total_hours['name'] }}
                                                    </div>
                                                    <div class="text-xs font-bold text-right text-stone-700 w-12 md:w-16">
                                                        {{ $total_hours['value'] }}
                                                    </div> 
                                                </div>
                                            </div>
                                            @endif
                                        @endforeach
                                    </td>

                                    <!-- additional earnings -->
                                    <td class="px-2 md:px-4 py-3 text-sm space-y-4  align-top w-80">
                                        {{-- additional_earnings --}}
                                        @if(count($data['additional_earnings']) > 0)
                                            @foreach($data['additional_earnings'] as $key => $additional_earnings)
                                                @if($additional_earnings['visible'] == true)
                                                    <div class="grid grid-cols-6 items-center space-x-4" wire:key="{{ $data['user_id'] }},additional_earnings,{{ $key }}">
                                                        <div class="flex justify-end col-span-2">
                                                            <p class="text-xs font-semibold text-stone-500 text-right">
                                                                {{ $additional_earnings['name'] }}
                                                            </p>
                                                        </div>
                                                        <div class="col-span-4 space-x-4 ">
                                                            <input type="number" class="text-xs text-stone-900 font-bold py-1 px-2 border w-28 rounded-sm border-stone-200"
                                                                wire:model="collection.{{ $data['user_id'] }}.additional_earnings.{{ $key }}.amount" 
                                                                name="collection[{{ $data['user_id'] }}][additional_earnings][{{ $key }}][amount]"  
                                                            >
                                                            <button wire:click="removeAdditionalEarnings({{ $key }}, {{ $data['user_id'] }})" class="ml-2 text-red-500 cursor-pointer" x-cloak>
                                                                <i class="fa-solid fa-circle-xmark"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                        {{-- add additional_earnings --}}
                                        <div class="grid grid-cols-6 items-center space-x-4">
                                            <div class="col-span-2"></div>
                                            <div class="flex items-center col-span-4">
                                                <x-tables.button-add wire="openAdditionalEarningsModal({{ $data['user_id'] }})" >
                                                    Add Earnings
                                                </x-tables.button-add>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- deductions -->
                                    <td class="px-2 md:px-4 py-3 text-sm space-y-4  align-top w-80">
                                        {{-- deductions --}}
                                        @if(count($data['deductions']) > 0)
                                            @foreach($data['deductions'] as $key => $deductions)
                                                @if($deductions['visible'] == true)
                                                    <div class="grid grid-cols-6 items-center space-x-4" wire:key="{{ $data['user_id'] }},deductions,{{ $key }}">
                                                        <div class="flex justify-end col-span-2">
                                                            <p class="text-xs font-semibold text-stone-500 text-right">
                                                                {{ $deductions['name'] }}
                                                            </p>
                                                        </div>
                                                        <div class="col-span-4 space-x-4 ">
                                                            <input type="number" class="text-xs text-stone-900 font-bold py-1 px-2 border w-28 rounded-sm border-stone-200"
                                                                wire:model="collection.{{ $data['user_id'] }}.deductions.{{ $key }}.amount" 
                                                                name="collection[{{ $data['user_id'] }}][deductions][{{ $key }}][amount]"  
                                                            >
                                                            <button wire:click="removeAdditionalDeductions({{ $key }}, {{ $data['user_id'] }})" class="ml-2 text-red-500 cursor-pointer" x-cloak>
                                                                <i class="fa-solid fa-circle-xmark"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                        {{-- add deductions --}}
                                        <div class="grid grid-cols-6 items-center space-x-4">
                                            <div class="col-span-2"></div>
                                            <div class="flex items-center col-span-4">
                                                <x-tables.button-add wire="openAdditionalDeductionsModal({{ $data['user_id'] }})" >
                                                    Add Deductions
                                                </x-tables.button-add>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
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
                    <x-forms.button-rounded-md-primary wire:click="submitPayroll" wire:loading.attr="disabled">
                        Proceed
                    </x-forms.button-rounded-md-primary>
                </div>
            </div>
        </div>
    </div>
    @include('scripts.payroll.preview-script')
    @include('modals.payroll.preview-modal')
</div>
