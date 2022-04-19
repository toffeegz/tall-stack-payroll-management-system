<div>
    {{-- Be like water. --}}
    <div class="h-full overflow-y-auto px-6 md:px-auto">
        <div class="ml-12 md:ml-0 my-5 text-2xl font-semibold text-stone-700">
            Run Payroll
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            
            <div class="md:col-span-2">

                {{-- upcoming payroll --}}
                <div class="space-y-6 p-6">
                    <div class="space-y-2">
                        <div class="flex justify-center">
                            <div class="flex justify-center items-center bg-blue-100 rounded-full w-11 h-11">
                                <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 48 48" style=" fill:#3b82f6;"><path d="M 25.970703 1.9863281 A 1.50015 1.50015 0 0 0 24.939453 2.4394531 L 21.068359 6.3105469 A 1.50015 1.50015 0 0 0 20.785156 6.59375 L 20.439453 6.9394531 A 1.50015 1.50015 0 0 0 20.439453 9.0605469 L 24.939453 13.560547 A 1.50015 1.50015 0 1 0 27.060547 11.439453 L 24.654297 9.0332031 C 32.649194 9.3765807 39 15.918478 39 24 C 39 29.075961 36.48322 33.534381 32.634766 36.251953 A 1.5002303 1.5002303 0 1 0 34.365234 38.703125 C 38.97678 35.446698 42 30.070039 42 24 C 42 14.597089 34.745957 6.8649392 25.542969 6.078125 L 27.060547 4.5605469 A 1.50015 1.50015 0 0 0 25.970703 1.9863281 z M 14.578125 9.0117188 A 1.50015 1.50015 0 0 0 13.634766 9.296875 C 9.0232192 12.553302 6 17.929961 6 24 C 6 33.402911 13.254043 41.135061 22.457031 41.921875 L 20.939453 43.439453 A 1.50015 1.50015 0 1 0 23.060547 45.560547 L 26.931641 41.689453 A 1.50015 1.50015 0 0 0 27.214844 41.40625 L 27.560547 41.060547 A 1.50015 1.50015 0 0 0 27.560547 38.939453 L 23.060547 34.439453 A 1.50015 1.50015 0 0 0 21.984375 33.984375 A 1.50015 1.50015 0 0 0 20.939453 36.560547 L 23.345703 38.966797 C 15.350806 38.623419 9 32.081522 9 24 C 9 18.924039 11.51678 14.465619 15.365234 11.748047 A 1.50015 1.50015 0 0 0 14.578125 9.0117188 z"></path></svg>
                            </div>
                        </div>
                        <div class="flex items-center justify-center">
                            <div class="flex justify-between">
                                <div class="font-bold text-lg">
                                    {{ $latest_payroll_period->frequency_id == 1 ? 'Bi-Monthly':'Weekly' }} <span class="text-sm text-stone-500 font-light">(Due in 5 days)</span>
                                </div>
                                <button class="rounded-md p-2 items-center ml-2">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 48 48" style=" fill:#000;"><path d="M 36 5.0097656 C 34.205301 5.0097656 32.410791 5.6901377 31.050781 7.0507812 L 8.9160156 29.183594 C 8.4960384 29.603571 8.1884588 30.12585 8.0253906 30.699219 L 5.0585938 41.087891 A 1.50015 1.50015 0 0 0 6.9121094 42.941406 L 17.302734 39.974609 A 1.50015 1.50015 0 0 0 17.304688 39.972656 C 17.874212 39.808939 18.39521 39.50518 18.816406 39.083984 L 40.949219 16.949219 C 43.670344 14.228094 43.670344 9.7719064 40.949219 7.0507812 C 39.589209 5.6901377 37.794699 5.0097656 36 5.0097656 z M 36 7.9921875 C 37.020801 7.9921875 38.040182 8.3855186 38.826172 9.171875 A 1.50015 1.50015 0 0 0 38.828125 9.171875 C 40.403 10.74675 40.403 13.25325 38.828125 14.828125 L 36.888672 16.767578 L 31.232422 11.111328 L 33.171875 9.171875 C 33.957865 8.3855186 34.979199 7.9921875 36 7.9921875 z M 29.111328 13.232422 L 34.767578 18.888672 L 16.693359 36.962891 C 16.634729 37.021121 16.560472 37.065723 16.476562 37.089844 L 8.6835938 39.316406 L 10.910156 31.521484 A 1.50015 1.50015 0 0 0 10.910156 31.519531 C 10.933086 31.438901 10.975086 31.366709 11.037109 31.304688 L 29.111328 13.232422 z"></path></svg>
                                </button>
                            </div>
                        </div>
                        <div class="flex items-center justify-center">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="rounded-md bg-stone-100 p-4">
                                    <div class="text-stone-500 text-xs font-semibold">
                                        Pay Date
                                    </div>
                                    <div class="text-stone-900 text-base font-bold whitespace-nowrap">
                                        {{ Carbon\Carbon::parse($latest_payroll_period->payout_date)->format('m/d/Y') }}
                                    </div>
                                </div>
                                <div class="rounded-md bg-stone-100 p-4">
                                    <div class="text-stone-500 text-xs font-semibold">
                                        Payroll Period
                                    </div>
                                    <div class="text-stone-900 text-base font-bold flex-nowrap">
                                        {{ Carbon\Carbon::parse($latest_payroll_period->period_start)->format('m/d') }}
                                        &RightArrow; 
                                        {{ Carbon\Carbon::parse($latest_payroll_period->period_end)->format('m/d') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-center">
                        <button wire:click="submit" class="px-4 py-1.5 text-xs font-semibold leading-5 text-white transition-colors duration-150 bg-blue-500 border border-transparent rounded-full active:bg-blue-600 hover:bg-blue-600 focus:outline-none focus:shadow-outline-purple">
                            Run Payroll
                        </button>
                    </div>
                </div>


                {{-- things to review --}}
                <div class="space-y-4">
                    <h2 class="text-lg font-semibold text-black">
                        Things to review
                    </h2>
                    {{-- time in and out --}}
                    <a href="#" class="flex items-center justify-between p-4 mb-8 text-sm font-semibold text-stone-900 bg-white rounded-xl border border-stone-200 focus:outline-none focus:shadow-outline-stone">
                        <div class="flex flex-row space-x-4">
                            <div class="flex items-center bg-red-100 rounded-md p-2">
                                <svg class="w-6 h-6" x="0px" y="0px" viewBox="0 0 48 48" style=" fill:#ef4444;" xmlns="http://www.w3.org/2000/svg"><path d="M 24 4 C 12.972066 4 4 12.972074 4 24 C 4 35.027926 12.972066 44 24 44 C 35.027934 44 44 35.027926 44 24 C 44 12.972074 35.027934 4 24 4 z M 24 7 C 33.406615 7 41 14.593391 41 24 C 41 33.406609 33.406615 41 24 41 C 14.593385 41 7 33.406609 7 24 C 7 14.593391 14.593385 7 24 7 z M 23.476562 11.978516 A 1.50015 1.50015 0 0 0 22 13.5 L 22 25.5 A 1.50015 1.50015 0 0 0 23.5 27 L 31.5 27 A 1.50015 1.50015 0 1 0 31.5 24 L 25 24 L 25 13.5 A 1.50015 1.50015 0 0 0 23.476562 11.978516 z"></path></svg>
                            </div>
                            <div>
                                <div class="font-bold text-base">Review and approve attendance requests</div>
                                <div class="text-stone-500 text-sm font-light">You have 10 attendance requests to review</div>
                            </div>
                        </div>
                        <span>&RightArrow;</span>
                    </a>
                    {{-- cancel loan deduction --}}
                    <a href="#" class="flex items-center justify-between p-4 mb-8 text-sm font-semibold text-stone-900 bg-white rounded-xl border border-stone-200 focus:outline-none focus:shadow-outline-stone">
                        <div class="flex flex-row space-x-4">
                            <div class="flex items-center bg-blue-100 rounded-md p-2">
                                <svg class="w-6 h-6" style=" color:#3b82f6;" xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-coin" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <circle cx="12" cy="12" r="9"></circle>
                                    <path d="M14.8 9a2 2 0 0 0 -1.8 -1h-2a2 2 0 0 0 0 4h2a2 2 0 0 1 0 4h-2a2 2 0 0 1 -1.8 -1"></path>
                                    <path d="M12 6v2m0 8v2"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="font-bold text-base">Review and cancel loan automatic deduction requests</div>
                                <div class="text-stone-500 text-sm font-light">You have 10 loan deduction requests to review</div>
                            </div>
                        </div>
                        <span>&RightArrow;</span>
                    </a>
                </div>
            </div>
            {{-- other --}}
            <div class="space-y-4 md:-mt-12">
                <h2 class="text-base font-semibold text-black">
                    Other Payroll Options
                </h2>
    
                <div class="grid grid-cols-2 md:grid-cols-1 gap-4">
                    {{-- bonus payroll --}}
                    <div class="flex items-center justify-between p-4 text-sm font-semibold text-stone-900 bg-white rounded-xl border border-stone-200 focus:outline-none focus:shadow-outline-stone">
                        <div class="space-y-4">
                            <div>
                                <div class="items-center rounded-md p-2">
                                    <img src="{{ asset('storage/img/icons/gift-icon.png') }}" class="w-10 h-10 object-cover"/>
                                </div>
                                <div class="font-bold text-sm">
                                    Bonus Payroll
                                </div>
                                <div class="text-stone-500 text-xs font-light">
                                    Reward a employee with a bonus gift or commission.
                                </div>
                            </div>
                            <div>
                                <a href="#" class="text-blue-500 text-xs font-semibold">
                                    Run Bonus Payroll
                                </a>
                            </div>
                        </div>
                    </div>
    
                    {{-- off-cycle payroll --}}
                    <div class="flex items-center justify-between p-4 text-sm font-semibold text-stone-900 bg-white rounded-xl border border-stone-200 focus:outline-none focus:shadow-outline-stone">
                        <div class="space-y-4">
                            <div>
                                <div class="items-center rounded-md p-2">
                                    <img src="{{ asset('storage/img/icons/cash-icon.png') }}" class="w-10 h-10 object-cover"/>
                                </div>
                                <div class="font-bold text-sm">
                                    Off-Cycle Payroll
                                </div>
                                <div class="text-stone-500 text-xs font-light">
                                    Run a payroll outside of your regular pay schedule.
                                </div>
                            </div>
                            <div>
                                <a href="#" class="text-blue-500 text-xs font-semibold">
                                    Run Off-Cycle Payroll
                                </a>
                            </div>
                        </div>
                    </div>
    
                    {{-- termination --}}
                    <div class="flex items-center justify-between p-4 text-sm font-semibold text-stone-900 bg-white rounded-xl border border-stone-200 focus:outline-none focus:shadow-outline-stone">
                        <div class="space-y-4">
                            <div>
                                <div class="items-center rounded-md p-2">
                                    <img src="{{ asset('storage/img/icons/handshake-icon.png') }}" class="w-10 h-10 object-cover"/>
                                </div>
                                <div class="font-bold text-sm">
                                    Termination
                                </div>
                                <div class="text-stone-500 text-xs font-light">
                                    The payroll will appear above after an employee is dismissed.
                                </div>
                            </div>
                            <div>
                                <a href="#" class="text-blue-500 text-xs font-semibold">
                                    Go to Employees
                                </a>
                            </div>
                        </div>
                    </div>
    
                    {{-- missing payroll --}}
                    <div class="flex items-center justify-between p-4 text-sm font-semibold text-stone-900 bg-white rounded-xl border border-stone-200 focus:outline-none focus:shadow-outline-stone">
                        <div class="space-y-4">
                            <div>
                                <div class="items-center rounded-md p-2">
                                    <img src="{{ asset('storage/img/icons/calendar-icon.png') }}" class="w-10 h-10 object-cover"/>
                                </div>
                                <div class="font-bold text-sm">
                                    Missing Payroll
                                </div>
                                <div class="text-stone-500 text-xs font-light">
                                    The payroll will appear above if there is missed payroll
                                </div>
                            </div>
                            <div>
                                <a href="#" class="text-blue-500 text-xs font-semibold">
                                    Report a missing payroll
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>
