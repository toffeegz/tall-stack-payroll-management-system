<div>
    {{-- Be like water. --}}
    <div class="h-full overflow-y-auto px-6 md:px-auto">
        <div class="ml-12 md:ml-0 my-5 text-2xl font-semibold text-stone-700">
            Run Payroll
        </div>

        <div class="grid grid-cols-1 md:grid-cols-10 gap-5">
            
            {{-- PAYSLIPS --}}
                <div class="md:col-span-6">

                    
                    {{-- Table header --}}
                    <div class="flex justify-between my-4 space-x-4">
                        <div class="flex justify-between space-x-4">
                            <div class="md:w-72">
                                <x-forms.search-input placeholder="search employee name" name="search"/>
                            </div>
                        </div>
                        <div class="space-x-2">
                            <x-forms.select wire:model="search_payslip_using_paydate">
                                <option value="">- All -</option>
                                @foreach($previous_payrolls as $previous_payroll)
                                    <option value="{{ $previous_payroll->id }}">{{ $previous_payroll->payout_date }}</option>
                                @endforeach 
                            </x-forms.select>
                        </div>
                    </div>

                    {{-- table --}}
                    <div class="w-full overflow-hidden rounded-lg shadow-xs">
                        <div class="w-full overflow-x-auto">
                            <table class="w-full whitespace-no-wrap">
                                <thead>
                                    <tr class="text-xs font-semibold tracking-wide text-left text-stone-500 uppercase border-b rounded-t-md bg-gray-50">
                                        <th class="px-2 md:px-4 py-3 text-right">Employee</th>
                                        <th class="px-2 md:px-4 py-3 text-right">Gross Pay</th>
                                        <th class="px-2 md:px-4 py-3 text-right">Deductions</th>
                                        <th class="px-2 md:px-4 py-3 text-right">Net Pay</th>
                                        <th class="px-2 md:px-4 py-3 text-right">Pay Date</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y">
                                    @foreach($payslips as $payslip)
                                        <tr>
                                            <td class="px-2 md:px-4 py-3 align-top">
                                                <p class=" text-xs text-stone-700 font-bold">{{ $payslip->user->formal_name() }}</p>
                                            </td>
                                            <td class="px-2 md:px-4 py-3 align-top">
                                                <p class=" text-xs text-right text-stone-600 font-bold">
                                                    ₱{{ number_format($payslip->gross_pay, 2, '.', ',') }}
                                                </p>
                                            </td>
                                            <td class="px-2 md:px-4 py-3 align-top">
                                                <p class=" text-xs text-right text-stone-600 font-bold">
                                                    ₱{{ number_format($payslip->deductions, 2, '.', ',') }}
                                                </p>
                                            </td>
                                            <td class="px-2 md:px-4 py-3 align-top">
                                                <p class=" text-xs text-right text-stone-600 font-bold">
                                                    ₱{{ number_format($payslip->net_pay, 2, '.', ',') }}
                                                </p>
                                            </td>
                                            <td class="px-2 md:px-4 py-3 align-top">
                                                <p class=" text-xs text-right text-stone-600 font-bold">
                                                    {{ Carbon\Carbon::parse($payslip->payroll_period->payout_date)->format('M d, Y') }}
                                                </p>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{--  --}}
                        {{ $payslips->links() }}
                    </div>

                    
                </div>
            {{--  --}}
            {{-- PAYROLL --}}
                <div class="space-y-4 md:-mt-12 md:col-span-4">
                    <h2 class="text-base font-semibold text-black">
                        Payroll Options
                    </h2>
        
                    <div class="grid grid-cols-2 md:grid-cols-1 gap-4">
                        {{-- latest payroll --}}
                        @if($latest_payroll_period)
                            <div class="p-6 rounded-xl border border-stone-200 focus:outline-none focus:shadow-outline-stone">
                                <div class="space-y-2">
                                    <div class="flex justify-center">
                                        <div class="flex justify-center items-center bg-blue-100 rounded-full w-11 h-11">
                                            <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 48 48" style=" fill:#3b82f6;"><path d="M 25.970703 1.9863281 A 1.50015 1.50015 0 0 0 24.939453 2.4394531 L 21.068359 6.3105469 A 1.50015 1.50015 0 0 0 20.785156 6.59375 L 20.439453 6.9394531 A 1.50015 1.50015 0 0 0 20.439453 9.0605469 L 24.939453 13.560547 A 1.50015 1.50015 0 1 0 27.060547 11.439453 L 24.654297 9.0332031 C 32.649194 9.3765807 39 15.918478 39 24 C 39 29.075961 36.48322 33.534381 32.634766 36.251953 A 1.5002303 1.5002303 0 1 0 34.365234 38.703125 C 38.97678 35.446698 42 30.070039 42 24 C 42 14.597089 34.745957 6.8649392 25.542969 6.078125 L 27.060547 4.5605469 A 1.50015 1.50015 0 0 0 25.970703 1.9863281 z M 14.578125 9.0117188 A 1.50015 1.50015 0 0 0 13.634766 9.296875 C 9.0232192 12.553302 6 17.929961 6 24 C 6 33.402911 13.254043 41.135061 22.457031 41.921875 L 20.939453 43.439453 A 1.50015 1.50015 0 1 0 23.060547 45.560547 L 26.931641 41.689453 A 1.50015 1.50015 0 0 0 27.214844 41.40625 L 27.560547 41.060547 A 1.50015 1.50015 0 0 0 27.560547 38.939453 L 23.060547 34.439453 A 1.50015 1.50015 0 0 0 21.984375 33.984375 A 1.50015 1.50015 0 0 0 20.939453 36.560547 L 23.345703 38.966797 C 15.350806 38.623419 9 32.081522 9 24 C 9 18.924039 11.51678 14.465619 15.365234 11.748047 A 1.50015 1.50015 0 0 0 14.578125 9.0117188 z"></path></svg>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-center">
                                        <div class="flex justify-between">
                                            <div class="font-bold text-lg">
                                                {{ $latest_payroll_period->frequency_id == 1 ? 'Semi-Monthly':'Weekly' }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-center">
                                        <div class="flex justify-between gap-4">
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
                                <div class="flex items-center justify-center pt-4">
                                    <button wire:click="submit" class="px-4 py-1.5 text-xs font-semibold leading-5 text-white transition-colors duration-150 bg-blue-500 border border-transparent rounded-full active:bg-blue-600 hover:bg-blue-600 focus:outline-none focus:shadow-outline-purple">
                                        Run Payroll
                                    </button>
                                </div>
                            </div>
                        @endif

                        {{-- things to review --}}
                        <div class="space-y-4">
                            {{-- <h2 class="text-lg font-semibold text-black">
                                Things to review
                            </h2> --}}
                            @if($total_pending_attendance != 0)
                                {{-- time in and out --}}
                                <a href="{{ route('attendance') }}" class="flex items-center justify-between p-4  text-sm font-semibold text-stone-900 bg-white rounded-xl border border-stone-200 focus:outline-none focus:shadow-outline-stone">
                                    <div class="flex flex-row space-x-4">
                                        <div class="flex items-center bg-red-100 rounded-md p-2">
                                            <svg class="w-6 h-6" x="0px" y="0px" viewBox="0 0 48 48" style=" fill:#ef4444;" xmlns="http://www.w3.org/2000/svg"><path d="M 24 4 C 12.972066 4 4 12.972074 4 24 C 4 35.027926 12.972066 44 24 44 C 35.027934 44 44 35.027926 44 24 C 44 12.972074 35.027934 4 24 4 z M 24 7 C 33.406615 7 41 14.593391 41 24 C 41 33.406609 33.406615 41 24 41 C 14.593385 41 7 33.406609 7 24 C 7 14.593391 14.593385 7 24 7 z M 23.476562 11.978516 A 1.50015 1.50015 0 0 0 22 13.5 L 22 25.5 A 1.50015 1.50015 0 0 0 23.5 27 L 31.5 27 A 1.50015 1.50015 0 1 0 31.5 24 L 25 24 L 25 13.5 A 1.50015 1.50015 0 0 0 23.476562 11.978516 z"></path></svg>
                                        </div>
                                        <div>
                                            <div class="font-bold text-sm">Review and approve attendance requests</div>
                                            <div class="text-stone-500 text-xs font-light">You have {{ $total_pending_attendance }} attendance requests to review</div>
                                        </div>
                                    </div>
                                    <span>&RightArrow;</span>
                                </a>
                            @endif
                        </div>

                        {{-- run previous payroll --}}
                        <div class="pb-4 flex items-center justify-between p-4 text-sm font-semibold text-stone-900 bg-white rounded-xl border border-stone-200 focus:outline-none focus:shadow-outline-stone">
                            <div class="space-y-4">
                                <div>
                                    <div class="items-center rounded-md p-2">
                                        <img src="{{ asset('storage/img/icons/calendar-icon.png') }}" class="w-10 h-10 object-cover"/>
                                    </div>
                                    <div class="font-bold text-sm">
                                        Run Previous Payroll
                                    </div>
                                    <div class="text-stone-500 text-xs font-light">
                                        The payroll will appear above if there is missed payroll
                                    </div>
                                </div>
                                <div>
                                    <a onclick="modalObject.openModal('modalPreviousPayroll')" class="cursor-pointer text-blue-500 text-xs font-semibold">
                                        Choose Payroll Period
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            {{--  --}}
        </div>
    </div>
    @include('modals.payroll.payroll-modal')
    @include('scripts.payroll.payroll-script')
</div>
