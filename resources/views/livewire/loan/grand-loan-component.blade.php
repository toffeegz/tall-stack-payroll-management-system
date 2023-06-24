<div>
    {{-- Because she competes with no one, no one can compete with her. --}}
    <div class="h-full overflow-y-auto">
        <div class="container px-6 mx-auto grid">
            <h2 class="my-6 text-2xl font-semibold text-stone-700">
                Grant Loan
            </h2>
            <div>
                {{-- Table header --}}
                <div class="flex justify-between my-4 space-x-4">
                    <div class="md:w-72">
                        <x-forms.search-input placeholder="search employee" name="search"/>
                    </div>
                    <div class="space-x-2 flex">
                        <x-forms.select wire:model="status">
                            <option value="">- All -</option>
                            <option value="1">Pending</option>
                            <option value="2">Approved</option>
                            <option value="3">Disapproved</option>
                        </x-forms.select>
                        <x-forms.button-rounded-md-secondary class="whitespace-nowrap py-3" wire:click="download">
                            <i class="fa-solid fa-download"></i>
                            <span class="hidden md:inline-flex">
                                Download
                            </span>
                        </x-forms.button-rounded-md-secondary>
                        <x-forms.button-rounded-md-primary class="whitespace-nowrap"  onclick="modalObject.openModal('modalGrantLoan')">
                            <i class="fa-solid fa-plus"></i>
                            <span class="hidden md:inline-flex">Grant Loan</span>
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
                                <th class="px-4 py-3 hidden md:table-cell">Date Requested</th>
                                <th class="px-4 py-3 hidden md:table-cell">Date Approved</th>
                                <th class="px-4 py-3 text-center">Status</th>
                                <th class="px-4 py-3 text-right hidden md:table-cell">Installment</th>
                                <th class="px-4 py-3 text-right">Amount</th>
                                <th class="px-4 py-3 text-right">Balance</th>
                                
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y "  >
                                @foreach($loans as $loan)
                                    <tr class="text-stone-700 cursor-pointer"  wire:click="openLoanDetails('{{ $loan->id }}')">
                                        <td class="px-4 py-3">
                                            <div class="flex items-center text-sm">
                                                <!-- Avatar with inset shadow -->
                                                <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block" >
                                                    <?php 
                                                        $profile_photo_path = $loan->user->profile_photo_path ? $loan->user->profile_photo_path : 'sample.png';
                                                    ?>
                                                    <img class="object-cover w-full h-full rounded-full"  src="{{ asset('storage/img/users/'. $profile_photo_path) }}" alt="" loading="lazy" />
                                                    <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true" ></div>
                                                </div>
                                                <div>
                                                    <p class="font-semibold">{{ $loan->user->informal_name() }}</p>
                                                    <p class="text-xs text-stone-600 ">
                                                        {{ $loan->user->code }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-xs hidden md:table-cell">
                                            {{ $loan->created_at ? Carbon\Carbon::parse($loan->created_at)->format('M d, Y') : '-' }}
                                        </td>
                                        <td class="px-4 py-3 text-xs hidden md:table-cell">
                                            {{ $loan->date_approved ? Carbon\Carbon::parse($loan->date_approved)->format('M d, Y') : '-' }}
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
                                        <td class="px-4 py-3 text-xs text-right text-stone-600 font-bold hidden md:table-cell">
                                            ₱{{ number_format($loan->installment_amount, 2, '.', ',') }}
                                        </td>
                                        <td class="px-4 py-3 text-xs text-right text-stone-600 font-bold">
                                            ₱{{ number_format($loan->amount, 2, '.', ',') }}
                                        </td>
                                        <td class="px-4 py-3 text-xs text-right text-stone-600 font-bold">
                                            ₱{{ number_format($loan->balance, 2, '.', ',') }}
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
    </div>


    
    {{-- MODALS --}}

        @include('scripts.loan.grand-loan-script')
        @include('modals.loan.grand-loan-modal')
</div>




