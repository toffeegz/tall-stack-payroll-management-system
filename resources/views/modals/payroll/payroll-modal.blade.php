{{-- modal total hours --}}
    <x-modal-small id="modalPreviousPayroll" title="Payroll Period" wire:ignore.self>
        {{-- modal body --}}
            <div class="space-y-4 my-4">
                <div class="">
                    <x-forms.label>
                        Frequency
                    </x-forms.label>
                    <x-forms.select wire:model="selected_frequency_id">
                        <option value="1">Semi-Monthly</option>
                        <option value="2">Weekly</option>
                    </x-forms.select>
                </div>
                {{-- payroll period --}}
                <div class="">
                    <x-forms.label>
                        Payroll Period
                    </x-forms.label>
                    <x-forms.select wire:model="selected_payroll_period">
                        <option value="">- Select payroll period -</option>
                        @foreach($previous_payrolls as $previous_payroll)
                            <option value="{{ $previous_payroll->id }}">
                                {{ Carbon\Carbon::parse($previous_payroll->period_start)->format('m/d/Y') }}
                                -
                                {{ Carbon\Carbon::parse($previous_payroll->period_end)->format('m/d/Y') }} 
                                ({{ Carbon\Carbon::parse($previous_payroll->payout_date)->format('m/d/Y') }})
                            </option>
                        @endforeach 
                    </x-forms.select>
                    @error($selected_payroll_period)
                        <span class="text-xs text-red-500 italic">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        {{-- end modal body --}}
        {{-- modal footer --}}
            <div class="w-full py-4 flex justify-end space-x-2 border-t border-stone-200">
                <x-forms.button-rounded-md-secondary onclick="modalObject.closeModal('modalTotalHours')">
                    Cancel
                </x-forms.button-rounded-md-secondary>
                <x-forms.button-rounded-md-primary wire:click="submitPreviousPayroll">
                    Run Payroll
                </x-forms.button-rounded-md-primary>
            </div>
        {{-- end modal footer --}}
    </x-modal-small>
{{--  --}}
