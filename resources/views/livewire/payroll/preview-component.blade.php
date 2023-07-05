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

                            @if(isset($data['is_visible'])) 
                                <tr class="">
                                    {{-- employee --}}
                                    <td class="px-2 md:px-4 py-3 align-top">
                                        <div class="flex items-center justify-center">
                                            <div class=" w-56">
                                                <div class="text-sm space-y-1">
                                                    <p class="text-stone-900 font-bold">{{ $data['name'] }}</p>
                                                </div>
                                                
                                                <p class="text-xs font-semibold text-stone-700">Daily Rate</p>
                                                @foreach ($data['rates_range'] as $range)
                                                    <div class="flex justify-between w-52">
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
                                    <td class="px-2 md:px-4 py-3 text-sm space-y-2  align-top">
                                        {{-- earnings --}}
                                        @if(count($data['additional_earnings']) > 0)
                                        @foreach($data['additional_earnings'] as $key => $additional_earnings)
                                            @if($additional_earnings['visible'] == true)
                                                <div class="flex space-x-1 justify-between w-28 md:w-40" wire:key="{{ $data['user_id'] }},additional_earnings,{{ $key }}">
                                                    <div class="items-center flex justify-center space-x-2 md:w-20 " x-data="{ deleteBtn: false }" @click.away="deleteBtn = false">
                                                        <a class="cursor-pointer text-xs font-semibold text-stone-500" x-on:click="deleteBtn = !deleteBtn">
                                                            {{ $additional_earnings['name'] }}
                                                        </a>
                                                        <button wire:click="removeAdditionalEarnings({{ $key }}, {{ $data['user_id'] }})" x-show="deleteBtn" class="ml-2 text-red-500 cursor-pointer" x-cloak>
                                                            <i class="fa-solid fa-circle-xmark"></i>
                                                        </button>
                                                    </div>
                                                    <input type="number" wire:model="collection.{{ $data['user_id'] }}.additional_earnings.{{ $key }}.amount" name="collection[{{ $data['user_id'] }}][additional_earnings][{{ $key }}][amount]" class="text-xs text-stone-900 font-bold py-1 px-2 border w-16 rounded-sm border-stone-200">
                                                </div>
                                            @endif
                                        @endforeach
                                        @endif
                                        {{-- add earnings --}}
                                        <div class="flex justify-center">
                                            <x-tables.button-add wire="openAdditionalEarningsModal({{ $data['user_id'] }})" >
                                                Add Earnings
                                            </x-tables.button-add>
                                        </div>
                                    </td>

                                    <!-- deductions -->
                                    <td class="px-2 md:px-4 py-3 text-sm space-y-2  align-top">
                                        {{-- deductions --}}
                                        @if(count($data['deductions']) > 0)
                                        @foreach($data['deductions'] as $key => $deductions)
                                            @if($deductions['visible'] == true)
                                                <div class="flex space-x-1 justify-between w-28 md:w-40" wire:key="{{ $data['user_id'] }},deductions,{{ $key }}">
                                                    <div class="items-center flex justify-center space-x-2 md:w-20 " x-data="{ deleteBtn: false }" @click.away="deleteBtn = false">
                                                        <a class="cursor-pointer text-xs font-semibold text-stone-500" x-on:click="deleteBtn = !deleteBtn">
                                                            <span class="hidden md:inline-flex">{{ $deductions['name'] }}</span>
                                                            <span class="md:hidden uppercase">{{ $deductions['acronym'] }}</span>
                                                        </a>
                                                        <button wire:click="removeAdditionalDeductions({{ $key }}, {{ $data['user_id'] }})" x-show="deleteBtn" class="ml-2 text-red-500 cursor-pointer" x-cloak>
                                                            <i class="fa-solid fa-circle-xmark"></i>
                                                        </button>
                                                    </div>
                                                    <input type="number" wire:model="collection.{{ $data['user_id'] }}.deductions.{{ $key }}.amount" name="collection[{{ $data['user_id'] }}][deductions][{{ $key }}][amount]"  class="text-xs text-stone-900 font-bold py-1 px-2 border w-20 rounded-sm border-stone-200">
                                                </div>
                                            @endif
                                        @endforeach
                                        @endif
                                        {{-- add deductions --}}
                                        <div class="flex justify-center">
                                            <x-tables.button-add wire="openAdditionalDeductionsModal({{ $data['user_id'] }})" >
                                                Add Deductions
                                            </x-tables.button-add>
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
                    <x-forms.button-rounded-md-primary wire:click="submit" wire:loading.attr="disabled">
                        Proceed
                    </x-forms.button-rounded-md-primary>
                </div>
            </div>
        </div>
    </div>
</div>
