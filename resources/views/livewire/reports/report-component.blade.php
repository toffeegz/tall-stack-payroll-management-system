<div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    <div class="h-full overflow-y-auto px-6 md:px-auto">
        <div class="ml-12 md:ml-0 my-5 text-2xl font-semibold text-stone-700">
            Reports
        </div>
        <div class="grid grid-cols-1 md:grid-cols-10 gap-5">
            
            {{-- MAIN REPORT --}}
                <div class="md:col-span-6 space-y-6">

                    {{-- PAYROLL SUMMARY --}}
                        <div class="p-6 space-y-4 rounded-xl border border-stone-200 focus:outline-none focus:shadow-outline-stone">
                            <div class="space-y-2">
                                <div class="font-bold text-lg">
                                    Payroll Summary
                                </div>
                                <div class="text-sm text-stone-700">
                                    Summary of the pay run, displays the pay period total gross pay, as well as the total government remittances from both the employee and employer.
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="">
                                    <x-customs.label>
                                        Frequency
                                    </x-customs.label>
                                    <x-customs.select wire:model="frequency_id">
                                        <option value="1">Semi-Monthly</option>
                                        <option value="2">Weekly</option>
                                    </x-customs.select>
                                </div>
                                <div class="">
                                    <x-customs.label>
                                        Payroll period
                                    </x-customs.label>
                                    <x-customs.select wire:model="payroll_period">
                                        <option value="">- Select payroll period -</option>
                                        @foreach($payroll_periods as $payroll_period)
                                            <option value="{{ $payroll_period->id }}">
                                                {{ Carbon\Carbon::parse($payroll_period->period_start)->format('m/d/Y') }} 
                                                - 
                                                {{ Carbon\Carbon::parse($payroll_period->period_end)->format('m/d/Y') }} 
                                                ({{ Carbon\Carbon::parse($payroll_period->payout_date)->format('m/d/Y') }})
                                            </option>
                                        @endforeach
                                    </x-customs.select>
                                    @error('payroll_period')
                                        <p class="italic text-red-500 text-xs">payroll period is required</p>
                                    @enderror
                                </div>
                                
                            </div>
                            <div class="flex justify-end">
                                <button wire:click="generatePayrollSummaryReport" wire:loading.attr="disabled" class="px-4 py-1.5 text-xs font-semibold leading-5 text-white transition-colors duration-150 bg-blue-500 border border-transparent rounded-full active:bg-blue-600 hover:bg-blue-600 focus:outline-none focus:shadow-outline-purple">
                                    Generate Report 
                                    <i class="ml-2 fa-solid fa-arrow-right-long"></i>
                                </button>
                            </div>
                        </div>

                        <a href="#" class="flex items-center justify-between p-4 mb-8 text-sm font-semibold text-stone-900 bg-white rounded-xl border-2 border-stone-100 focus:outline-none focus:shadow-outline-stone">
                            <div class="flex flex-row space-x-4">
                                <div class="flex items-center bg-blue-100 rounded-md p-1">
                                    <img src="{{ asset('storage/img/icons/transaction-icon.png') }}" class="w-10 h-10 object-cover"/>
                                </div>
                                <div class="">
                                    <div class="font-bold text-base">
                                        Payroll Journal
                                    </div>
                                    <div class="text-stone-700 text-sm font-light">
                                        View your employee's past earnings, deductions, and taxes
                                    </div>
                                </div>
                            </div>
                            <button class="cursor-pointer text-blue-500 text-xs font-semibold">
                                View <i class="fa-solid fa-angle-right ml-2 fa-xs"></i>
                            </button>
                        </a>
                    {{--  --}}
                {{--  --}}
                    
                </div>
            {{--  --}}
            {{-- OTHER REPORT --}}
                <div class="space-y-4 md:-mt-10 md:col-span-4">
                    <h2 class="text-base font-semibold text-black">
                        Other Reports
                    </h2>

                    {{-- tax contribution report --}}
                        <div class="pb-4 flex items-center justify-between p-4 text-sm font-semibold text-stone-900 bg-white rounded-xl border border-stone-200 focus:outline-none focus:shadow-outline-stone">
                            <div class="space-y-4">
                                <div>
                                    <div class="items-center rounded-md p-2">
                                        <img src="{{ asset('storage/img/icons/tax.png') }}" class="w-10 h-10 object-cover"/>
                                    </div>
                                    <div class="font-bold text-sm">
                                        Tax Contribution Report
                                    </div>
                                    <div class="text-stone-500 text-xs font-light">
                                        Displays the total employee and employer share of SSS, Philhealth, Pag-ibig tax contribution.
                                    </div>
                                </div>
                                <div>
                                    <a onclick="modalObject.openModal('modalTaxContribution')" class="cursor-pointer text-blue-500 text-xs font-semibold">
                                        View <i class="fa-solid fa-angle-right ml-2 fa-xs"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    {{--  --}}
        
                    {{-- loan report --}}
                        <div class="pb-4 flex items-center justify-between p-4 text-sm font-semibold text-stone-900 bg-white rounded-xl border border-stone-200 focus:outline-none focus:shadow-outline-stone">
                            <div class="space-y-4">
                                <div>
                                    <div class="items-center rounded-md p-2">
                                        <img src="{{ asset('storage/img/icons/cash-icon.png') }}" class="w-10 h-10 object-cover"/>
                                    </div>
                                    <div class="font-bold text-sm">
                                        Loan Report
                                    </div>
                                    <div class="text-stone-500 text-xs font-light">
                                        This report prints cash advance requests and cash advance balances.
                                    </div>
                                </div>
                                <div>
                                    <a onclick="modalObject.openModal('modalLoan')" class="cursor-pointer text-blue-500 text-xs font-semibold">
                                        View <i class="fa-solid fa-angle-right ml-2 fa-xs"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    {{--  --}}

                    {{-- employee list report --}}
                        <div class="pb-4 flex items-center justify-between p-4 text-sm font-semibold text-stone-900 bg-white rounded-xl border border-stone-200 focus:outline-none focus:shadow-outline-stone">
                            <div class="space-y-4">
                                <div>
                                    <div class="items-center rounded-md p-2">
                                        <img src="{{ asset('storage/img/icons/workers.png') }}" class="w-10 h-10 object-cover"/>
                                    </div>
                                    <div class="font-bold text-sm">
                                        Employee List Report
                                    </div>
                                    <div class="text-stone-500 text-xs font-light">
                                        This report prints an employee list by seniority date. 
                                    </div>
                                </div>
                                <div>
                                    <a onclick="modalObject.openModal('modalEmployeeList')" class="cursor-pointer text-blue-500 text-xs font-semibold">
                                        View <i class="fa-solid fa-angle-right ml-2 fa-xs"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    {{--  --}}

                    
        
                </div>
            {{--  --}}
        </div>
    </div>
    @include('modals.reports.report-modal')
    @include('scripts.reports.report-script')
</div>
