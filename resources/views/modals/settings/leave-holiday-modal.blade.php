
{{-- modal add leave types --}}
<x-modal-small id="modalAddLeaveType" title="Add Designation" wire:ignore.self>
    {{-- modal body --}}
    <div class="space-y-4 my-4">


        {{-- company name --}}
        <div>
            <x-forms.label>
                Designation Name
            </x-forms.label>
            <x-forms.input wire:model="new_designation_name" type="text"></x-forms.input>
            @error('new_designation_name')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <x-forms.label>
                Daily Rate
            </x-forms.label>
            <x-forms.input wire:model="new_daily_rate" type="number"></x-forms.input>
            @error('new_daily_rate')
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