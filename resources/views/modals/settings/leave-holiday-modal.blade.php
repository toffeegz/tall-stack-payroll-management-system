
{{-- modal add leave types --}}
<x-modal-small id="modalAddLeaveType" title="Add Leave Type" wire:ignore.self>
    {{-- modal body --}}
    <div class="space-y-4 my-4">


        {{-- company name --}}
        <div>
            <x-forms.label>
                Name
            </x-forms.label>
            <x-forms.input wire:model="leave_type_name" type="text"></x-forms.input>
            @error('leave_type_name')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <x-forms.label>
                Days
            </x-forms.label>
            <x-forms.input wire:model="leave_type_days" type="number"></x-forms.input>
            @error('leave_type_days')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>


    </div>
    {{-- end modal body --}}
    {{-- modal footer --}}
    <div class="w-full py-4 flex justify-end space-x-2 border-t border-stone-200">
        <x-forms.button-rounded-md-secondary onclick="modalObject.closeModal('modalAddLeaveType')">
            Close
        </x-forms.button-rounded-md-secondary>
        <x-forms.button-rounded-md-primary wire:click="addLeaveType" >
            Submit
        </x-forms.button-rounded-md-primary>
    </div>
    {{-- end modal footer --}}
</x-modal-small>
{{-- end loan --}}


{{-- modal add leave types --}}
<x-modal-small id="modalEditLeaveType" title="Edit Leave Type" wire:ignore.self>
    {{-- modal body --}}
    <div class="space-y-4 my-4">


        {{-- company name --}}
        <div>
            <x-forms.label>
                Name
            </x-forms.label>
            <x-forms.input wire:model="edit_leave_type_name" type="text"></x-forms.input>
            @error('edit_leave_type_name')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <x-forms.label>
                Days
            </x-forms.label>
            <x-forms.input wire:model="edit_leave_type_days" type="number"></x-forms.input>
            @error('edit_leave_type_days')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>


    </div>
    {{-- modal footer --}}
    <div class="w-full py-4 flex justify-between space-x-2 border-t border-stone-200">
        <x-forms.button-rounded-md-danger wire:click="deleteLeaveType" >
            Delete
        </x-forms.button-rounded-md-danger>
        <div class="flex justify-end space-x-2 ">
            <x-forms.button-rounded-md-secondary onclick="modalObject.closeModal('modalEditLeaveType')">
                Close
            </x-forms.button-rounded-md-secondary>
            <x-forms.button-rounded-md-primary wire:click="editLeaveType" >
                Update
            </x-forms.button-rounded-md-primary>
        </div>
    </div>
    {{-- end modal footer --}}
</x-modal-small>
{{-- end loan --}}




{{-- modal add holiday --}}
<x-modal-small id="modalAddHoliday" title="Add Holiday" wire:ignore.self>
    {{-- modal body --}}
    <div class="space-y-4 my-4">


        {{-- company name --}}
        <div>
            <x-forms.label>
                Name
            </x-forms.label>
            <x-forms.input wire:model="holiday_name" type="text"></x-forms.input>
            @error('holiday_name')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <x-forms.label>
                    Date
                </x-forms.label>
                <x-forms.input wire:model="holiday_date" type="date"></x-forms.input>
                @error('holiday_date')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <x-forms.label>
                    Type
                </x-forms.label>
                <x-forms.select wire:model="holiday_type">
                    <option value="1">Legal Holiday</option>
                    <option value="0">Special Holiday</option>
                </x-forms.select>
                @error('holiday_type')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
        </div>


    </div>
    {{-- end modal body --}}
    {{-- modal footer --}}
    <div class="w-full py-4 flex justify-end space-x-2 border-t border-stone-200">
        <x-forms.button-rounded-md-secondary onclick="modalObject.closeModal('modalAddHoliday')">
            Close
        </x-forms.button-rounded-md-secondary>
        <x-forms.button-rounded-md-primary wire:click="addHoliday" >
            Submit
        </x-forms.button-rounded-md-primary>
    </div>
    {{-- end modal footer --}}
</x-modal-small>
{{-- end loan --}}


{{-- modal add holiday --}}
<x-modal-small id="modalEditHoliday" title="Edit Holiday" wire:ignore.self>
    {{-- modal body --}}
    <div class="space-y-4 my-4">


        {{-- company name --}}
        <div>
            <x-forms.label>
                Name
            </x-forms.label>
            <x-forms.input wire:model="selected_holiday_name" type="text"></x-forms.input>
            @error('selected_holiday_name')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <x-forms.label>
                    Date
                </x-forms.label>
                <x-forms.input wire:model="selected_holiday_date" type="date"></x-forms.input>
                @error('selected_holiday_date')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <x-forms.label>
                    Type
                </x-forms.label>
                <x-forms.select wire:model="selected_holiday_type">
                    <option value="1">Legal Holiday</option>
                    <option value="0">Special Holiday</option>
                </x-forms.select>
                @error('selected_holiday_type')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
        </div>


    </div>
    {{-- end modal body --}}
    {{-- end modal footer --}}
    <div class="w-full py-4 flex justify-between space-x-2 border-t border-stone-200">
        <x-forms.button-rounded-md-danger wire:click="deleteHoliday" >
            Delete
        </x-forms.button-rounded-md-danger>
        <div class="flex justify-end space-x-2 ">
            <x-forms.button-rounded-md-secondary onclick="modalObject.closeModal('modalEditHoliday')">
                Close
            </x-forms.button-rounded-md-secondary>
            <x-forms.button-rounded-md-primary wire:click="editHoliday" >
                Update
            </x-forms.button-rounded-md-primary>
        </div>
    </div>
</x-modal-small>
{{-- end loan --}}