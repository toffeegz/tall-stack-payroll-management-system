<div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    <div class="h-full overflow-y-auto px-6 md:px-auto">
        <div class="ml-12 md:ml-0 my-5 text-2xl font-semibold text-stone-700">
            Loans (Cash Advance)
        </div>
        <div class="grid grid-cols-1 md:grid-cols-10 gap-5">
            
            {{-- left panel --}}
                <div class="md:col-span-7 space-y-6"> 
                    
                    @livewire('loan.user-payment-history', ['user_id' => Auth::user()->id])
                    @livewire('loan.user-request-history', ['user_id' => Auth::user()->id])
                    
                </div>
            {{--  --}}


            {{-- right panel --}}
                <div class="space-y-4 md:-mt-10 md:col-span-3">

                    
                    {{-- balance --}}
                    @if($total_balance != 0)
                        <div class="space-y-2 {{ $paid_percentage >= 100 ? 'bg-green-500' : 'bg-purple-700' }} p-8 text-sm font-semibold text-stone-900 rounded-xl border border-stone-200 ">
                            
                            <div class="w-full text-stone-200 text-xs text-center">
                                @if($paid_percentage >= 100)
                                    Your loan is fully paid 
                                    <span>
                                        <i class="fa-solid fa-check-double fa-lg text-white"></i>
                                    </span>
                                @else 
                                    Total left to Pay
                                @endif
                            </div>

                            <div class="w-full text-white text-3xl font-bold text-center">
                                ₱{{ number_format($total_balance, 2, '.', ',') }}
                            </div>

                            <div class="flex items-center justify-between space-x-2">
                                <div class="w-full bg-stone-400 rounded-full h-2">
                                    <div class="bg-white h-2 rounded-full" style="width: {{ $paid_percentage }} %"></div>
                                </div>
                                <p class="text-xs text-white font-semibold">{{ $paid_percentage }}%</p>
                            </div>
                        </div>
                    @endif
                    {{--  --}}

                    {{-- if pending request --}}
                    @if($pending_request)
                        <a href="#" class="flex flex-col p-4 mb-8 text-sm font-semibold text-stone-900 bg-white rounded-xl border border-stone-200">
                            <div class="flex flex-row space-x-4">
                                <div class="flex items-center bg-yellow-100 rounded-md p-1">
                                    <img src="{{ asset('storage/img/icons/loan.png') }}" class="w-10 h-10 object-cover"/>
                                </div>
                                <div class="">
                                    <div class="font-bold text-base">
                                        Pending Loan Request
                                    </div>
                                    <div class="text-stone-700 text-xs font-light">
                                        You can cancel loan request anytime
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-end">
                                <button onclick="modalObject.openModal('modalCancelLoan')" class="cursor-pointer text-red-500 text-xs font-semibold">
                                    Cancel <i class="fa-solid fa-angle-right ml-2 fa-xs"></i>
                                </button>
                            </div>
                        </a>
                    @endif

                    {{-- eligible to request --}}
                    @if($existing_loan->count() == 0 && !$pending_request)
                        <div class="space-y-4 bg-purple-700 p-8 rounded-xl border border-stone-200 ">
                            
                            <div class="flex justify-between">
                                <p class="text-white text-sm font-bold">Request Cash Advance</p>
                                {{-- <p class="text-white text-sm font-bold">Request Cash Advance</p> --}}
                            </div>
                            <div class="">
                                <div class="space-y-1">
                                    <div class="flex justify-between">
                                        <div class="text-xs text-purple-200 font-bold">Amount</div>
                                        <div class="text-xs text-purple-200 font-bold">Installment</div>
                                    </div>
                                    <div class="flex justify-between">
                                        <div>
                                            <div class="relative text-xl">
                                                <span class="absolute text-white font-bold">₱</span>
                                                <input type="number " wire:model="amount" class="w-24 text-white font-bold bg-transparent focus:outline-none focus:ring-0 focus:border-stone-200 border-b border-transparent pl-4">
                                            </div>
                                            @error('amount')
                                                <span class="italic text-red-300 text-xs">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div>
                                            <div class="relative text-xl">
                                                <span class="absolute text-white font-bold">₱</span>
                                                <div class="text-white font-bold bg-transparent pl-4">
                                                    {{ number_format($installment_amount, 2, '.', ',') }}
                                                </div>
                                            </div>
                                            @error('install_period')
                                                <span class="italic text-red-300 text-xs">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                            </div>

        
                            <div class="relative pt-1">
                                <label class="form-label text-xs text-purple-200 font-bold">Installment Period: {{ $install_period }}</label>
                                <input
                                  type="range" wire:model="install_period"
                                  class="form-range form-range appearance-none w-full bg-purple-200 h-2 rounded-full p-0 focus:outline-none focus:ring-0 focus:shadow-none"
                                  max="12" min="1"
                                />
                                @error('install_period')
                                    <span class="italic text-red-300 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="flex justify-end">
                                <button onclick="modalObject.openModal('modalLoanRequest')" class="px-4 py-1.5 text-xs font-semibold leading-5 text-white transition-colors duration-150 bg-blue-500 border border-transparent rounded-full active:bg-blue-600 hover:bg-blue-600 focus:outline-none focus:shadow-outline-purple">
                                    Request
                                    <i class="ml-2 fa-solid fa-arrow-right-long"></i>
                                </button>
                            </div>

                        </div>
                    @endif


                    {{-- download history of payments --}}
                        <div class="pb-4 flex items-center justify-between p-4 text-sm font-semibold text-stone-900 bg-white rounded-xl border border-stone-200 focus:outline-none focus:shadow-outline-stone">
                            <div class="space-y-4">
                                <div>
                                    <div class="items-center rounded-md p-2">
                                        <img src="{{ asset('storage/img/icons/cash-icon.png') }}" class="w-10 h-10 object-cover"/>
                                    </div>
                                    <div class="font-bold text-sm">
                                        Loan History
                                    </div>
                                    <div class="text-stone-500 text-xs font-light">
                                        Download copy of cash advance requests with loan details such as amount, install period, date, etc.
                                    </div>
                                </div>
                                <div>
                                    <button wire:click="downloadRequestHistory" class="cursor-pointer text-blue-500 text-xs font-semibold">
                                        Download <i class="fa-solid fa-download"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    {{--  --}}

                     {{-- download history of payments --}}
                     <div class="pb-4 flex items-center justify-between p-4 text-sm font-semibold text-stone-900 bg-white rounded-xl border border-stone-200 focus:outline-none focus:shadow-outline-stone">
                        <div class="space-y-4">
                            <div>
                                <div class="items-center rounded-md p-2">
                                    <img src="{{ asset('storage/img/icons/loan.png') }}" class="w-10 h-10 object-cover"/>
                                </div>
                                <div class="font-bold text-sm">
                                    Payment History
                                </div>
                                <div class="text-stone-500 text-xs font-light">
                                    Download copy of loan payment history with details.
                                </div>
                            </div>
                            <div>
                                <button wire:click="downloadPaymentHistory" class="cursor-pointer text-blue-500 text-xs font-semibold">
                                    Download <i class="fa-solid fa-download"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                {{--  --}}
                    
        
                </div>
            {{--  --}}
        </div>
    </div>
    @include('modals.loan.loan-modal')
    @include('scripts.loan.loan-script')
</div>
