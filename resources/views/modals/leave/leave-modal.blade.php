
{{-- modal notif hours --}}
<x-modal-small id="modalNotif" title="Success" wire:ignore.self>
    {{-- modal body --}}
    <div class="text-center p-5 flex-auto justify-center">
        <x-notification.success title="Great!">
            Your request has been submitted
        </x-notification.success>
    </div>
    {{-- end modal body --}}
    {{-- modal footer --}}
    {{-- end modal footer --}}
</x-modal-small>
{{--  --}}



{{-- modal employment details --}}
<x-modal-small id="modalLeaveDetails" title="Leave Details ({{ $selected_leave ? $selected_leave->user->informal_name():'' }})" wire:ignore.self>
    {{-- modal body --}}
        <div class="space-y-4 my-4">

            {{-- start and end date --}}
            <div class="flex justify-between gap-4">
                {{-- date --}}
                <div class="w-full">
                    <x-forms.label>
                        Start Date
                    </x-forms.label>
                    <x-forms.input type="date" wire:model="selected_start_date"></x-forms.input>
                    @error('selected_start_date')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                @if($selected_type_id == 3)
                    {{-- end date --}}
                    <div class="w-full">
                        <x-forms.label>
                            End Date
                        </x-forms.label>
                        <x-forms.input type="date" wire:model="selected_end_date"></x-forms.input>
                        @error('selected_end_date')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>
                @endif
            </div>

            {{-- leave type --}}
            <div class="w-full">
                <x-forms.label>
                    Leave Type
                </x-forms.label>
                <x-forms.select class="w-full" wire:model="selected_leave_type_id">
                    <option value="">- select type -</option>
                    @foreach($leave_types as $leave_type)
                        <option value="{{ $leave_type->id }}">{{ $leave_type->name }}</option>
                    @endforeach 
                </x-forms.select>
                @error('selected_leave_type_id')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                {{-- day type --}}
                <div class="w-full">
                    <x-forms.label>
                        Day Type
                    </x-forms.label>
                    <div class="flex flex-col text-sm">
                        <div class="form-check px-2">
                            <input wire:model="selected_type_id" value="1" class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" 
                            type="radio">
                            <label class="form-check-label inline-block text-gray-800 mt-1 " for="rd_selected_day_type" >
                                Full day
                            </label>
                        </div>
                        <div class="form-check px-2">
                            <input wire:model="selected_type_id" value="2" class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" 
                            type="radio">
                            <label class="form-check-label inline-block text-gray-800 mt-1 " for="rd_selected_day_type" >
                                Half day
                            </label>
                        </div>
                        <div class="form-check px-2">
                            <input wire:model="selected_type_id" value="3" class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" 
                            type="radio">
                            <label class="form-check-label inline-block text-gray-800 mt-1 " for="rd_selected_day_type" >
                                Above a day
                            </label>
                        </div>
                    </div>
                    @error('selected_type_id')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                @if(Auth::user()->hasRole('administrator'))
                {{-- status --}}
                <div class="w-full">
                    <x-forms.label>
                        Status
                    </x-forms.label>
                    <div class="flex flex-col text-sm">
                        <div class="form-check px-2">
                            <input wire:model="selected_status" value="1" class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" 
                            type="radio">
                            <label class="form-check-label inline-block text-gray-800 mt-1 " for="rd_selected_day_type" >
                                Pending
                            </label>
                        </div>
                        <div class="form-check px-2">
                            <input wire:model="selected_status" value="2" class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" 
                            type="radio">
                            <label class="form-check-label inline-block text-gray-800 mt-1 " for="rd_selected_day_type" >
                                Approved
                            </label>
                        </div>
                        <div class="form-check px-2">
                            <input wire:model="selected_status" value="3" class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" 
                            type="radio">
                            <label class="form-check-label inline-block text-gray-800 mt-1 " for="rd_selected_day_type" >
                                Disapproved
                            </label>
                        </div>
                    </div>
                    @error('selected_type_id')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                @endif
            </div>


            @if(Auth::user()->hasRole('administrator'))
            {{-- is_paid_leave --}}
            <div class="ml-2">
                <x-forms.checkbox wire:model="selected_is_paid"></x-forms.checkbox>
                <x-forms.checkbox-label>
                    Paid Leave
                </x-forms.checkbox-label>
            </div>
            @endif
            {{-- reason --}}
            <div class="w-full">
                <x-forms.label>
                    Reason
                </x-forms.label>
                <x-forms.textarea wire:model="selected_reason" rows="4">
                </x-forms.textarea>
                @error('selected_reason')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>


        </div>
    {{-- end modal body --}}
    {{-- modal footer --}}
        <div class="w-full py-4 flex justify-end space-x-2 border-t border-stone-200">
            <x-forms.button-rounded-md-secondary onclick="modalObject.closeModal('modalLeaveDetails')">
                Cancel
            </x-forms.button-rounded-md-secondary>
            @if(Auth::user()->hasRole('administrator') || $selected_status == 1)
            <x-forms.button-rounded-md-primary wire:click="updateLeaveDetails" wire:loading.attr="disabled">
                Update
            </x-forms.button-rounded-md-primary>
            @endif
        </div>
    {{-- end modal footer --}}
</x-modal-small>
{{--  --}}



{{-- modal employment details --}}
<x-modal-small id="modalDownload" title="Download Leave History" wire:ignore.self>
    {{-- modal body --}}
        <div class="space-y-4 my-4">

            {{-- start and end date --}}
            <div class="flex justify-between gap-4">
                {{-- date --}}
                <div class="w-full">
                    <x-forms.label>
                        Start Date
                    </x-forms.label>
                    <x-forms.input type="date" wire:model="download_start_date"></x-forms.input>
                    @error('download_start_date')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                {{-- end date --}}
                <div class="w-full">
                    <x-forms.label>
                        End Date
                    </x-forms.label>
                    <x-forms.input type="date" wire:model="download_end_date"></x-forms.input>
                    @error('download_end_date')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
    {{-- end modal body --}}
    {{-- modal footer --}}
        <div class="w-full py-4 flex justify-end space-x-2 border-t border-stone-200">
            <x-forms.button-rounded-md-secondary onclick="modalObject.closeModal('modalDownload')">
                Cancel
            </x-forms.button-rounded-md-secondary>
            <x-forms.button-rounded-md-primary wire:click="downloadLeaveHistory" wire:loading.attr="disabled">
                Download
            </x-forms.button-rounded-md-primary>
        </div>
    {{-- end modal footer --}}
</x-modal-small>
{{--  --}}