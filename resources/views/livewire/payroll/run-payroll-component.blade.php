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

        {{-- users without rate --}}
        @error($users_daily_rate)
            <div class="flex items-center justify-between p-4 mb-8 text-sm font-semibold text-stone-900 bg-red-50 rounded-xl border border-red-100 focus:outline-none focus:shadow-outline-stone">
                <div class="flex flex-row space-x-4">
                    <div class="flex items-center bg-red-100 rounded-md p-2">
                        <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 48 48" style=" fill:#f63b3b;"><path d="M 24 4 C 12.972292 4 4 12.972292 4 24 C 4 27.275316 4.8627078 30.334853 6.2617188 33.064453 L 4.09375 40.828125 C 3.5887973 42.631528 5.3719261 44.41261 7.1757812 43.908203 L 14.943359 41.740234 C 17.671046 43.137358 20.726959 44 24 44 C 35.027708 44 44 35.027708 44 24 C 44 12.972292 35.027708 4 24 4 z M 24 7 C 33.406292 7 41 14.593708 41 24 C 41 33.406292 33.406292 41 24 41 C 20.997029 41 18.192258 40.218281 15.744141 38.853516 A 1.50015 1.50015 0 0 0 14.609375 38.71875 L 7.2226562 40.78125 L 9.2851562 33.398438 A 1.50015 1.50015 0 0 0 9.1503906 32.263672 C 7.7836522 29.813476 7 27.004518 7 24 C 7 14.593708 14.593708 7 24 7 z M 23.976562 12.978516 A 1.50015 1.50015 0 0 0 22.5 14.5 L 22.5 26.5 A 1.50015 1.50015 0 1 0 25.5 26.5 L 25.5 14.5 A 1.50015 1.50015 0 0 0 23.976562 12.978516 z M 24 31 A 2 2 0 0 0 24 35 A 2 2 0 0 0 24 31 z"></path></svg>
                    </div>
                    <div>
                        <div class="font-bold text-base text-red-600">Users daily rate is required</div>
                        <div class="text-stone-500 text-sm font-light">Set users daily rate to proceed payroll</div>
                    </div>
                </div>
            </div>
        @enderror

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
                                                @if($data['acronym'] == 'nd')
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
                                                @else
                                                    {{-- update no changing of hours --}}
                                                    <div class="flex space-x-1 justify-between w-28 md:w-40" wire:key="{{ $user['id'] }},total_hours,{{ $key }}">
                                                        <div class="cursor-pointer text-xs font-semibold text-stone-500">
                                                            <span class="hidden md:inline-flex">{{ $data['name'] }}</span>
                                                            <span class="md:hidden uppercase">{{ $data['acronym'] }}</span>
                                                        </div>
                                                        <div class="text-xs text-stone-900 font-bold py-1 px-2 border w-16 rounded-sm border-stone-200">
                                                            {{ $data['amount'] }}
                                                        </div>
                                                    </div>
                                                @endif
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
