
{{-- modal additional earnings --}}
    <x-modal-small id="modalAdditionalEarnings" title="Additional Earnings ({{ $selected_user_id !== null ? $collection[$selected_user_id]['name']: '' }})" wire:ignore.self>
        {{-- modal body --}}
            <div class="space-y-4 my-4">
                {{-- earning type --}}
                @if($selected_user_id != null)
                    <div class="">
                        <x-forms.label>
                            Earning Type
                        </x-forms.label>
                        <x-forms.select wire:model="selected_type">
                            <option value="">- Select earning type -</option>
                            @foreach($collection[$selected_user_id]['additional_earnings'] as $key => $value)
                                @if($value['visible'] == false)
                                    <option value="{{ $key }}">{{ $value['name']}}</option>
                                @endif
                            @endforeach 
                        </x-forms.select>
                        @error($selected_type)
                            <span class="text-xs text-red-500 italic">{{ $message }}</span>
                        @enderror
                    </div>
                @endif
            </div>
        {{-- end modal body --}}
        {{-- modal footer --}}
            <div class="w-full py-4 flex justify-end space-x-2 border-t border-stone-200">
                <x-forms.button-rounded-md-secondary onclick="modalObject.closeModal('modalAdditionalEarnings')">
                    Cancel
                </x-forms.button-rounded-md-secondary>
                <x-forms.button-rounded-md-primary wire:click="submitAdditionalEarnings">
                    Submit
                </x-forms.button-rounded-md-primary>
            </div>
        {{-- end modal footer --}}
    </x-modal-small>
{{--  --}}



{{-- modal additional deduction --}}
    <x-modal-small id="modalAdditionalDeductions" title="Additional Deductions ({{ $selected_user_id !== null ? $collection[$selected_user_id]['name']: '' }})" wire:ignore.self>
        {{-- modal body --}}
            <div class="space-y-4 my-4">
                {{-- deduction type --}}
                @if($selected_user_id != null)
                    <div class="">
                        <x-forms.label>
                            Deduction Type
                        </x-forms.label>
                        <x-forms.select wire:model="selected_type">
                            <option value="">- Select deduction type -</option>
                            @foreach($collection[$selected_user_id]['deductions'] as $key => $value)
                                @if($value['visible'] == false)
                                    <option value="{{ $key }}">{{ $value['name']}}</option>
                                @endif
                            @endforeach 
                        </x-forms.select>
                        @error($selected_type)
                            <span class="text-xs text-red-500 italic">{{ $message }}</span>
                        @enderror
                    </div>
                @endif
            </div>
        {{-- end modal body --}}
        {{-- modal footer --}}
            <div class="w-full py-4 flex justify-end space-x-2 border-t border-stone-200">
                <x-forms.button-rounded-md-secondary onclick="modalObject.closeModal('modalAdditionalDeductions')">
                    Cancel
                </x-forms.button-rounded-md-secondary>
                <x-forms.button-rounded-md-primary wire:click="submitAdditionalDeductions">
                    Submit
                </x-forms.button-rounded-md-primary>
            </div>
        {{-- end modal footer --}}
    </x-modal-small>
{{--  --}}
