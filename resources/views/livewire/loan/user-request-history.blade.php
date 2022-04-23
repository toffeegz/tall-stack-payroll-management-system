<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
    {{-- Loan history --}}
    <div>
        {{-- Table header --}}
        <div class="flex justify-start my-4 px-2">
            <p class="font-bold">Loan History</p>
        </div>

        {{-- loan history table --}}
        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                    <tr class="text-xs font-semibold tracking-wide text-left text-stone-500 uppercase border-b  bg-stone-50 ">
                        <th class="px-4 py-3">Details</th>
                        <th class="px-4 py-3">Installment</th>
                        <th class="px-4 py-3 text-center">Status</th>
                        <th class="px-4 py-3 text-center ">Date</th>
                        <th class="px-4 py-3 text-right">Amount</th>
                        
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y "  >
                        @foreach($loans as $loan)
                            <tr class="text-stone-700">
                                
                                <td class="px-4 py-3 text-sm text-stone-900 ">
                                    <p class="line-clamp-2 ">{{ $loan->details }}</p>
                                </td>

                                <td class="px-4 py-3 text-xs text-left text-stone-600 font-bold">
                                    ₱{{ number_format($loan->installment_amount, 2, '.', ',') }}
                                </td>

                                
                                <td class="px-4 py-3 text-xs text-center">
                                    @if($loan->status == 1)
                                        <span class="px-2 py-1 font-semibold text-stone-700 bg-stone-100 leading-tight bg rounded-full ">
                                            Pending
                                        </span>
                                    @elseif($loan->status == 2)
                                        <span class="px-2 py-1 font-semibold text-green-700 bg-green-100 leading-tight bg rounded-full ">
                                            Approved
                                        </span>
                                    @elseif($loan->status == 3)
                                        <span class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full ">
                                            Disapproved
                                        </span>
                                    @endif
                                </td>
                                

                                <td class="px-4 py-3 text-xs text-center font-semibold whitespace-nowrap">
                                    {{ $loan->created_at ? Carbon\Carbon::parse($loan->created_at)->format('M d, Y') : '' }}
                                </td>

                                <td class="px-4 py-3 text-xs text-right text-stone-600 font-bold">
                                    ₱{{ number_format($loan->amount, 2, '.', ',') }}
                                </td>

                                
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{ $loans->links() }}
    </div>
</div>
