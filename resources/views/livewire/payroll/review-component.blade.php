<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    <div class="h-full overflow-y-auto px-6 md:px-32">
        <div class="ml-12 md:ml-0 my-5 flex justify-between">
            <div class="text-2xl font-semibold text-stone-700">
                Review Payroll 
            </div>
            <div class="text-sm text-stone-500">
                Pay period: 
                {{ Carbon\Carbon::parse($period_start)->format('m/d/Y') . " - " . Carbon\Carbon::parse($period_end)->format('m/d/Y') }}
            </div>
        </div>


        {{-- Table header --}}
        <div class="my-10">
            <div class="w-full flex pb-2 space-x-8">
                <div class="flex flex-col">
                    <span class="text-xs text-stone-500 font-semibold">Total Payroll</span>
                    <span class="text-lg text-stone-700 font-bold">₱{{ number_format($total_net_pay, 2, '.', ',') }}</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-xs text-stone-500 font-semibold">Period Start</span>
                    <span class="text-md text-stone-700 font-semibold">{{ Carbon\Carbon::parse($period_start)->format('l M dS, Y') }}</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-xs text-stone-500 font-semibold">Period Start</span>
                    <span class="text-md text-stone-700 font-semibold">{{ Carbon\Carbon::parse($period_end)->format('l M dS, Y') }}</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-xs text-stone-500 font-semibold">Payout Date</span>
                    <span class="text-md text-stone-700 font-semibold">{{ Carbon\Carbon::parse($payout_date)->format('l M dS, Y') }}</span>
                </div>
            </div>
            <div class="w-full  flex items-start">
                <div class="flex justify-end space-x-4 ">
                    <x-forms.button-rounded-md-primary wire:click="submitPayroll" wire:loading.attr="disabled">
                        Submit Payroll
                    </x-forms.button-rounded-md-primary>
                    {{-- <x-forms.button-rounded-md-secondary wire:click="saveForLater">
                        Save for Later
                    </x-forms.button-rounded-md-secondary> --}}
                </div>
            </div>
        </div>

        {{-- Employee Table --}}
        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left text-stone-500 uppercase border-b rounded-t-md bg-gray-50">
                            <th class="px-2 md:px-4 py-3 text-right">Employee</th>
                            <th class="px-2 md:px-4 py-3 text-right">Basic Pay</th>
                            <th class="px-2 md:px-4 py-3 text-right">Gross Pay</th>
                            <th class="px-2 md:px-4 py-3 text-right">Tax</th>
                            <th class="px-2 md:px-4 py-3 text-right">Deductions</th>
                            <th class="px-2 md:px-4 py-3 text-right">NetPay</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y">
                        @foreach($payrolls as $payroll)
                            <tr>
                                <td class="px-2 md:px-4 py-3 align-top">
                                    <p class=" text-xs text-stone-700 font-bold">{{ $payroll['full_name'] }}</p>
                                </td>
                                <td class="px-2 md:px-4 py-3 align-top">
                                    <p class=" text-xs text-right text-stone-600 font-bold">
                                        ₱{{ number_format($payroll['basic_pay'], 2, '.', ',') }}
                                    </p>
                                </td>
                                <td class="px-2 md:px-4 py-3 align-top">
                                    <p class=" text-xs text-right text-stone-600 font-bold">
                                        ₱{{ number_format($payroll['gross_pay'], 2, '.', ',') }}
                                    </p>
                                </td>
                                <td class="px-2 md:px-4 py-3 align-top">
                                    <p class=" text-xs text-right text-stone-600 font-bold" wire:key="{{ $payroll['user_id'] }}.{{ $payroll['tax_contributions'] }}">
                                        ₱{{ number_format($payroll['tax_contributions'], 2, '.', ',') }}
                                        @if($payroll['is_tax_exempted'] == false)
                                            <a class="cursor-pointer text-blue-500 ml-2" wire:click="editTaxContribution({{ $payroll['user_id'] }})"><i class="fa-solid fa-pen"></i></a>
                                        @endif
                                    </p>
                                </td>
                                <td class="px-2 md:px-4 py-3 align-top">
                                    <p class=" text-xs text-right text-stone-600 font-bold">
                                        ₱{{ number_format($payroll['total_deductions'], 2, '.', ',') }}
                                    </p>
                                </td>
                                <td class="px-2 md:px-4 py-3 align-top">
                                    <p class=" text-xs text-right text-stone-600 font-bold">
                                        ₱{{ number_format($payroll['net_pay'], 2, '.', ',') }}
                                    </p>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{--  --}}
            
        </div>
    </div>
    @include('scripts.payroll.review-payroll-script')
    @include('modals.payroll.review-payroll-modal')
</div>