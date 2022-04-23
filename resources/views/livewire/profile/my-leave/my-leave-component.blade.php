<div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    <div class="h-full overflow-y-auto px-6 md:px-auto">
        <div class="ml-12 md:ml-0 my-5 text-2xl font-semibold text-stone-700">
            My Leave
        </div>
        <div class="grid grid-cols-1 md:grid-cols-10 gap-5">
            
            {{-- left panel --}}
            <div class="md:col-span-6 space-y-6"> 
                <div>
                    {{-- Table header --}}
                    <div class="flex justify-between my-4 px-2">
                        <p class="font-bold">Leave History</p>
                        <div>
                            <button wire:click="download" class="cursor-pointer text-blue-500 text-xs font-semibold">
                                Download <i class="fa-solid fa-download"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- New Table -->
                    <div class="w-full overflow-hidden rounded-lg shadow-xs">
                        <div class="w-full overflow-x-auto">
                            <table class="w-full whitespace-no-wrap">
                                <thead>
                                <tr class="text-xs font-semibold tracking-wide text-left text-stone-500 uppercase border-b  bg-stone-50 ">
                                    
                                    <th class="px-4 py-3">Start Date</th>
                                    <th class="px-4 py-3">End Date</th>
                                    <th class="px-4 py-3">Duration (hrs)</th>
                                    <th class="px-4 py-3">Day Type</th>
                                    <th class="px-4 py-3">Leave Type</th>
                                    <th class="px-4 py-3">Status</th>
                                    
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y "  >
                                    @foreach($leaves as $leave)
                                        <tr class="text-stone-700 cursor-pointer"  wire:click="goToProfile({{ $leave->id }})">
                                            <td class="px-4 py-3 text-xs font-semibold">
                                                {{ $leave->start_date ? Carbon\Carbon::parse($leave->start_date)->format('d/m/Y') : '' }}
                                            </td>
                                            <td class="px-4 py-3 text-xs font-semibold">
                                                {{ $leave->end_date ? Carbon\Carbon::parse($leave->end_date)->format('d/m/Y') : '' }}
                                            </td>
                                            <td class="px-4 py-3 text-sm font-semibold">
                                                {{ $leave->hours_duration }}hrs
                                            </td>
                                            <td class="px-4 py-3 text-xs font-semibold whitespace-nowrap">
                                                {{ config('company.leave_type.'.$leave->type_id) }}
                                            </td>
                                            <td class="px-4 py-3 text-xs font-semibold whitespace-nowrap">
                                                {{ $leave->leaveType->name }}
                                            </td>
                                            <td class="px-4 py-3 text-xs text-center">
                                                @if($leave->status == 1)
                                                    <span class="px-4 py-1 font-semibold text-stone-700 bg-stone-100 leading-tight bg rounded-full ">
                                                        Pending
                                                    </span>
                                                @elseif($leave->status == 2)
                                                    <span class="px-4 py-1 font-semibold text-green-700 bg-green-100 leading-tight bg rounded-full ">
                                                        Approved
                                                    </span>
                                                @elseif($leave->status == 3)
                                                    <span class="px-4 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full ">
                                                        Disapproved
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3 text-sm">
                                                {{ $leave->duration }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{ $leaves->links() }}
                </div>
            </div>
            {{-- right panel --}}
            <div class="md:col-span-4 space-y-6"> 
                {{-- download history of payments --}}
                <div class="pb-4 flex items-center justify-between p-4 text-sm font-semibold text-stone-900 bg-white rounded-xl border border-stone-200 focus:outline-none focus:shadow-outline-stone">
                    <div class="space-y-4 w-full">
                        <div>
                            <div class="items-center rounded-md p-2">
                                <img src="{{ asset('storage/img/icons/leave.jpg') }}" class="w-10 h-10 object-cover"/>
                            </div>
                            <div class="font-bold text-sm">
                                Apply for Leave
                            </div>
                            <div class="text-stone-500 text-xs font-light">
                                Apply for a leave before the date requested
                            </div>
                        </div>

                        <div class="space-y-4">
                            {{--  --}}
                            <div class="grid grid-cols-2 gap-4">
                                <div class="space-y-4">
                                    {{-- leave type --}}
                                    <div class="w-full">
                                        <x-forms.label>
                                            Leave Type
                                        </x-forms.label>
                                        <x-forms.select class="w-full" wire:model="leave_type">
                                            <option value="">- select type -</option>
                                            @foreach($leave_types as $leave_type)
                                                <option value="{{ $leave_type->id }}">{{ $leave_type->name }}</option>
                                            @endforeach 
                                        </x-forms.select>
                                        @error('leave_type')
                                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                        @enderror
                                    </div>
                                        {{-- day type --}}
                                    <div class="w-full">
                                        <x-forms.label>
                                            Day Type
                                        </x-forms.label>
                                        <div class="flex flex-col space-y-2">
                                            <div class="form-check px-2">
                                                <input wire:model="type" value="1" class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                                <label class="form-check-label inline-block text-gray-800  mt-1" for="flexRadioDefault1">
                                                    Full day
                                                </label>
                                            </div>
                                            <div class="form-check px-2">
                                                <input wire:model="type" value="2" class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                                <label class="form-check-label inline-block text-gray-800  mt-1" for="flexRadioDefault1">
                                                    Half day
                                                </label>
                                            </div>
                                            <div class="form-check px-2">
                                                <input wire:model="type" value="3" class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                                <label class="form-check-label inline-block text-gray-800  mt-1" for="flexRadioDefault1">
                                                    Above a day
                                                </label>
                                            </div>
                                        </div>
                                        @error('type')
                                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="space-y-4">
                                    {{-- date --}}
                                    <div class="w-full">
                                        <x-forms.label>
                                            Start Date
                                        </x-forms.label>
                                        <x-forms.input type="date" wire:model="start_date"></x-forms.input>
                                        @error('start_date')
                                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    @if($type == 3)
                                    {{-- end date --}}
                                    <div class="w-full">
                                        <x-forms.label>
                                            End Date
                                        </x-forms.label>
                                        <x-forms.input type="date" wire:model="end_date"></x-forms.input>
                                        @error('end_date')
                                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    @endif
                                </div>
                            </div>

                            {{-- reason --}}
                            <div class="w-full">
                                <x-forms.label>
                                    Reason
                                </x-forms.label>
                                <x-forms.textarea wire:model="reason" rows="4">
                                </x-forms.textarea>
                                @error('reason')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                @enderror
                            </div>


                        </div>

                        <div class="flex justify-start">
                            <button wire:click="applyLeave" wire:loading.attr="disabled" class="px-4 py-1.5 text-xs font-semibold leading-5 text-white transition-colors duration-150 bg-blue-500 border border-transparent rounded-full active:bg-blue-600 hover:bg-blue-600 focus:outline-none focus:shadow-outline-purple">
                                Apply Leave
                                <i class="ml-2 fa-solid fa-arrow-right-long"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('scripts.profile.my-leave-script')
    @include('modals.profile.my-leave-modal')
</div>
