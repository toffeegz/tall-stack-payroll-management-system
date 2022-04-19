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
                        @foreach($payroll as $user)
                            @if($user['visible'] == true)
                                <tr class="">
                                    {{-- employee --}}
                                    <td class="px-2 md:px-4 py-3 align-top">
                                        <div class=" max-h-fit space-y-2">
                                            <div class="text-sm space-y-1">
                                                <p class="text-stone-900 font-bold">{{ $user['full_name'] }}</p>
                                            </div>
                                            <div class="flex space-x-2 justify-between w-28 md:w-40" wire:key="{{ $user['id'] }},daily_rate">
                                                <p class="text-xs font-semibold text-stone-500 md:w-20 items-center flex justify-center">
                                                    <span class="hidden md:inline-flex">Daily Rate</span>
                                                    <span class="md:hidden">Rate</span>
                                                </p>
                                                <input type="number" wire:model="payroll.{{ $user['id'] }}.daily_rate" name="payroll[{{ $user['id'] }}][daily_rate]" class="text-xs text-stone-900 font-bold py-1 px-2 border w-20 rounded-sm border-stone-200">
                                            </div>
                                            @if($user['daily_rate'] == 0)
                                                <div class="text-red-500 text-xs font-semibold text-center w-full">No Rate found</div> 
                                            @endif
                                        </div>

                                    </td>
                                    {{-- total hours --}}
                                    <td class="px-2 md:px-4 py-3 text-sm space-y-2  align-top">
                                        {{-- total hours --}}
                                        @foreach($user['total_hours'] as $key => $data)
                                            @if($data['visible'] == true)
                                                <div class="flex space-x-1 justify-between w-28 md:w-40" wire:key="{{ $user['id'] }},total_hours,{{ $key }}">
                                                    <div class="items-center flex justify-center space-x-2 md:w-20 " x-data="{ deleteBtn: false }" @click.away="deleteBtn = false">
                                                        <a class="cursor-pointer text-xs font-semibold text-stone-500" x-on:click="deleteBtn = !deleteBtn">
                                                            <span class="hidden md:inline-flex">{{ $data['name'] }}</span>
                                                            <span class="md:hidden uppercase">{{ $data['acronym'] }}</span>
                                                        </a>
                                                        <button wire:click="removeTotalHours({{ $key }}, {{ $user['id'] }})" x-show="deleteBtn" class="ml-2 text-red-500 cursor-pointer" x-cloak>
                                                            <i class="fa-solid fa-circle-xmark"></i>
                                                        </button>
                                                    </div>
                                                    <input type="number" wire:model="payroll.{{ $user['id'] }}.total_hours.{{ $key }}.amount" name="payroll[{{ $user['id'] }}][total_hours][{{ $key }}][amount]" class="text-xs text-stone-900 font-bold py-1 px-2 border w-16 rounded-sm border-stone-200">
                                                </div>
                                            @endif
                                        @endforeach
                                        {{-- add total hours --}}
                                        <x-tables.button-add wire="openTotalHoursModal({{ $user['id'] }})" >
                                            Add hours
                                        </x-tables.button-add>
                                    </td>
                                    {{-- additional earnings --}}
                                    <td class="px-2 md:px-4 py-3 text-sm space-y-2  align-top">
                                        {{-- earnings --}}
                                        @foreach($user['additional_earnings'] as $key => $data)
                                            @if($data['visible'] == true)
                                                <div class="flex space-x-1 justify-between w-28 md:w-40" wire:key="{{ $user['id'] }},additional_earnings,{{ $key }}">
                                                    <div class="items-center flex justify-center space-x-2 md:w-20 " x-data="{ deleteBtn: false }" @click.away="deleteBtn = false">
                                                        <a class="cursor-pointer text-xs font-semibold text-stone-500" x-on:click="deleteBtn = !deleteBtn">
                                                            <span class="hidden md:inline-flex">{{ $data['name'] }}</span>
                                                            <span class="md:hidden uppercase">{{ $data['acronym'] }}</span>
                                                        </a>
                                                        <button wire:click="removeAdditionalEarnings({{ $key }}, {{ $user['id'] }})" x-show="deleteBtn" class="ml-2 text-red-500 cursor-pointer" x-cloak>
                                                            <i class="fa-solid fa-circle-xmark"></i>
                                                        </button>
                                                    </div>
                                                    <input type="number" wire:model="payroll.{{ $user['id'] }}.additional_earnings.{{ $key }}.amount" name="payroll[{{ $user['id'] }}][additional_earnings][{{ $key }}][amount]" class="text-xs text-stone-900 font-bold py-1 px-2 border w-16 rounded-sm border-stone-200">
                                                </div>
                                            @endif
                                        @endforeach
                                        {{-- add earnings --}}
                                        <x-tables.button-add wire="openAdditionalEarningsModal({{ $user['id'] }})" >
                                            Add Earnings
                                        </x-tables.button-add>
                                    </td>
                                    {{-- deductions --}}
                                    <td class="px-2 md:px-4 py-3 text-sm space-y-2  align-top">
                                        {{-- deductions --}}
                                        @foreach($user['deductions'] as $key => $deduction_value)
                                            @if($deduction_value['visible'] == true)
                                                <div class="flex space-x-1 justify-between w-28 md:w-40" wire:key="{{ $user['id'] }},deductions,{{ $key }}">
                                                    <div class="items-center flex justify-center space-x-2 md:w-20 " x-data="{ deleteBtn: false }" @click.away="deleteBtn = false">
                                                        <a class="cursor-pointer text-xs font-semibold text-stone-500" x-on:click="deleteBtn = !deleteBtn">
                                                            <span class="hidden md:inline-flex">{{ $deduction_value['name'] }}</span>
                                                            <span class="md:hidden uppercase">{{ $deduction_value['acronym'] }}</span>
                                                        </a>
                                                        <button wire:click="removeDeductions({{ $key }}, {{ $user['id'] }})" x-show="deleteBtn" class="ml-2 text-red-500 cursor-pointer" x-cloak>
                                                            <i class="fa-solid fa-circle-xmark"></i>
                                                        </button>
                                                    </div>
                                                    <input type="number" wire:model="payroll.{{ $user['id'] }}.deductions.{{ $key }}.amount" name="payroll[{{ $user['id'] }}][deductions][{{ $key }}][amount]" class="text-xs text-stone-900 font-bold py-1 px-2 border w-16 rounded-sm border-stone-200">
                                                </div>
                                            @endif
                                        @endforeach
                                        {{-- add total hours --}}
                                        <x-tables.button-add wire="openDeductionsModal({{ $user['id'] }})" >
                                            Add deductions
                                        </x-tables.button-add>
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
                    Last Saved: {{ $timestamp_saved_payroll }}
                </div>
                <div class="flex justify-end space-x-2 ">
                    <x-forms.button-rounded-md-secondary wire:click="saveForLater">
                        Save for Later
                    </x-forms.button-rounded-md-secondary>
                    <x-forms.button-rounded-md-primary wire:click="submit">
                        Proceed
                    </x-forms.button-rounded-md-primary>
                </div>
            </div>
        </div>
    </div>
    @include('scripts.payroll.run-payroll-script')
    @include('modals.payroll.run-payroll-modal')
</div>
