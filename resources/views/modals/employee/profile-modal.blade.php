
{{-- modal employment details --}}

<x-modal-small id="modalInputEmployment" title="Employment Details" wire:ignore.self>
    {{-- modal body --}}
        <div class="space-y-4 my-4">
            
            @if($selected_input_employment == 'employment_status')
                {{-- employment_status --}}
                <div class="">
                    <x-forms.label>
                        Employment Status
                    </x-forms.label>
                    <x-forms.select wire:model="employment_status">
                        <option value="">- select employment status -</option>
                        @foreach(config('company.employment_status') as $key => $val)
                            <option value="{{ $key }}">{{ $val }}</option>
                        @endforeach 
                    </x-forms.select>
                    @error('employment_status')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
            @elseif($selected_input_employment == 'hired_date')
                {{-- hired_date --}}
                <div class="">
                    <x-forms.label>
                        Hired Date
                    </x-forms.label>
                    <x-forms.input type="date" wire:model="hired_date"></x-forms.input>
                    @error('hired_date')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
            @endif

        </div>
    {{-- end modal body --}}
    {{-- modal footer --}}
        <div class="w-full py-4 flex justify-end space-x-2 border-t border-stone-200">
            <x-forms.button-rounded-md-secondary onclick="modalObject.closeModal('modalEmploymentDetails')">
                Cancel
            </x-forms.button-rounded-md-secondary>
            <x-forms.button-rounded-md-primary wire:click="submitEmploymentDetails" wire:loading.attr="disabled">
                Update
            </x-forms.button-rounded-md-primary>
        </div>
    {{-- end modal footer --}}
</x-modal-small>

{{--  --}}
