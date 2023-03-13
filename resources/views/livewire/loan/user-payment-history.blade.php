<div>
    {{-- Nothing in the world is as soft and yielding as water. --}}
    {{-- payment history --}}
    <div>
        {{-- Table header --}}
        <div class="flex justify-start my-4 px-2">
            <p class="font-bold">Payment History</p>
        </div>

        {{-- payment history table --}}
        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                    <tr class="text-xs font-semibold tracking-wide text-left text-stone-500 uppercase border-b  bg-stone-50 ">
                        
                        <th class="px-4 py-3">Pay Date</th>
                        <th class="px-4 py-3">Notes</th>
                        <th class="px-4 py-3 text-right">Amount</th>
                        
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y "  >
                        @foreach($loan_installments as $loan_installment)
                            <tr class="text-stone-700r"  >
                                
                                <td class="px-4 py-3 text-xs font-semibold whitespace-nowrap">
                                    {{ $loan_installment->pay_date ? Carbon\Carbon::parse($loan_installment->pay_date)->format('M d, Y') : '-' }}
                                </td>

                                <td class="px-4 py-3 text-sm text-stone-900 ">
                                    <p class="line-clamp-2 ">{{ $loan_installment->notes }}</p>
                                </td>
                                
                                <td class="px-4 py-3 text-xs text-right text-stone-600 font-bold">
                                    ₱{{ number_format($loan_installment->amount, 2, '.', ',') }}
                                </td>
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{ $loan_installments->links() }}
    </div>
</div>
