{{-- modal total hours --}}
    <x-modal-small id="modalTotalHours" title="Hours ({{ $selected_user_name }})" wire:ignore.self>
        {{-- modal body --}}
            <div class="space-y-4 my-4">
                {{-- total hours --}}
                @if($selected_user_id != null)
                <div class="">
                    <x-forms.label>
                        Hour Type
                    </x-forms.label>
                    <x-forms.select wire:model="selected_type">
                        <option value="">- Select hour type -</option>
                        @foreach($payroll[$selected_user_id]['total_hours'] as $key => $value)
                            @if($value['visible'] == false)
                                <option value="{{ $key }}">{{ $value['name']}}</option>
                            @endif
                        @endforeach 
                    </x-forms.select>
                </div>
                @endif
            </div>
        {{-- end modal body --}}
        {{-- modal footer --}}
            <div class="w-full py-4 flex justify-end space-x-2 border-t border-stone-200">
                <x-forms.button-rounded-md-secondary onclick="modalObject.closeModal('modalTotalHours')">
                    Cancel
                </x-forms.button-rounded-md-secondary>
                <x-forms.button-rounded-md-primary wire:click="submitTotalHours">
                    Submit
                </x-forms.button-rounded-md-primary>
            </div>
        {{-- end modal footer --}}
    </x-modal-small>
{{--  --}}

{{-- modal additional earnings --}}
    <x-modal-small id="modalAdditionalEarnings" title="Additional Earnings ({{ $selected_user_name }})" wire:ignore.self>
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
                        @foreach($payroll[$selected_user_id]['additional_earnings'] as $key => $value)
                            @if($value['visible'] == false)
                                <option value="{{ $key }}">{{ $value['name']}}</option>
                            @endif
                        @endforeach 
                    </x-forms.select>
                </div>
                @endif
            </div>
        {{-- end modal body --}}
        {{-- modal footer --}}
            <div class="w-full py-4 flex justify-end space-x-2 border-t border-stone-200">
                <x-forms.button-rounded-md-secondary onclick="modalObject.closeModal('modalDailyRate')">
                    Cancel
                </x-forms.button-rounded-md-secondary>
                <x-forms.button-rounded-md-primary wire:click="submitAdditionalEarnings">
                    Submit
                </x-forms.button-rounded-md-primary>
            </div>
        {{-- end modal footer --}}
    </x-modal-small>
{{--  --}}

{{-- modal deductions --}}
<x-modal-small id="modalDeductions" title="Deductions ({{ $selected_user_name }})" wire:ignore.self>
    {{-- modal body --}}
        <div class="space-y-4 my-4">
            {{-- deductions type --}}
            @if($selected_user_id != null)
            <div class="">
                <x-forms.label>
                    Deduction Type
                </x-forms.label>
                <x-forms.select wire:model="selected_type">
                    <option value="">- Select deduction type -</option>
                    @foreach($payroll[$selected_user_id]['deductions'] as $key => $value)
                        @if($value['visible'] == false)
                            <option value="{{ $key }}">{{ $value['name']}}</option>
                        @endif
                    @endforeach 
                </x-forms.select>
            </div>
            @endif
        </div>
    {{-- end modal body --}}
    {{-- modal footer --}}
        <div class="w-full py-4 flex justify-end space-x-2 border-t border-stone-200">
            <x-forms.button-rounded-md-secondary onclick="modalObject.closeModal('modalDeductions')">
                Cancel
            </x-forms.button-rounded-md-secondary>
            <x-forms.button-rounded-md-primary wire:click="submitDeductions">
                Submit
            </x-forms.button-rounded-md-primary>
        </div>
    {{-- end modal footer --}}
</x-modal-small>
{{--  --}}