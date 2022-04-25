<div>
    {{-- Because she competes with no one, no one can compete with her. --}}
    <div class="h-full overflow-y-auto">
        <div class="container px-6 md:px-32 mx-auto grid">
            <h2 class="my-6 text-2xl font-semibold text-stone-700">
                Loan Installment
            </h2>
            <div>
                {{-- Table header --}}
                <div class="flex justify-between my-4 space-x-4">
                    <div class="md:w-72">
                        <x-forms.search-input placeholder="search employee" name="search"/>
                    </div>
                    <div class="space-x-2 flex">
                        <x-forms.button-rounded-md-primary class="whitespace-nowrap"  onclick="modalObject.openModal('modalPayLoan')">
                            <i class="fa-solid fa-plus"></i>
                            <span class="hidden md:inline-flex">Pay Loan</span>
                        </x-forms.button-rounded-md-primary>
                    </div>
                </div>

                <!-- New Table -->
                <div class="w-full overflow-hidden rounded-lg shadow-xs">
                    <div class="w-full overflow-x-auto">
                        <table class="w-full whitespace-no-wrap">
                            <thead>
                            <tr class="text-xs font-semibold tracking-wide text-left text-stone-500 uppercase border-b  bg-stone-50 ">
                                
                                <th class="px-4 py-3">Name</th>
                                <th class="px-4 py-3">Notes</th>
                                <th class="px-4 py-3 whitespace-nowrap">Pay Date</th>
                                <th class="px-4 py-3 text-right">Amount</th>
                                
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y "  >
                                @foreach($loan_installments as $loan_installment)
                                    <tr class="text-stone-700 cursor-pointer"  wire:click="openLoanDetails('{{ $loan_installment->id }}')">
                                        <td class="px-4 py-3">
                                            <div class="flex items-center text-sm">
                                                <!-- Avatar with inset shadow -->
                                                <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block" >
                                                    <img class="object-cover w-full h-full rounded-full"  src="{{ asset('storage/img/users/'. $loan_installment->user->profile_photo_path) }}" alt="" loading="lazy" />
                                                    <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true" ></div>
                                                </div>
                                                <div>
                                                    <p class="font-semibold whitespace-nowrap">{{ $loan_installment->user->informal_name() }}</p>
                                                    <p class="text-xs text-stone-600 ">
                                                        {{ $loan_installment->user->code }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-sm text-stone-900 ">
                                            <p class="line-clamp-2 ">{{ $loan_installment->notes }}</p>
                                        </td>
                                        <td class="px-4 py-3 text-xs font-semibold whitespace-nowrap">
                                            {{ $loan_installment->pay_date ? Carbon\Carbon::parse($loan_installment->pay_date)->format('M d, Y') : '' }}
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
    </div>


    
    {{-- MODALS --}}

        @include('scripts.loan.loan-installment-script')
        @include('modals.loan.loan-installment-modal')
</div>




