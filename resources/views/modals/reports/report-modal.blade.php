{{-- modal total hours --}}
<x-modal-small id="modalTaxContribution" title="Tax Contribution Report" wire:ignore.self>
    {{-- modal body --}}
        <div class="space-y-4 my-4">
            <div class="">
                <x-forms.label>
                    Frequency
                </x-forms.label>
                <x-forms.select wire:model="frequency_id">
                    <option value="1">Semi-Monthly</option>
                    <option value="2">Weekly</option>
                </x-forms.select>
            </div>
            {{-- payroll period --}}
            <div class="">
                <x-forms.label>
                    Payroll Period
                </x-forms.label>
                <x-forms.select wire:model="payroll_period">
                    <option value="">- Select payroll period -</option>
                    @foreach($payroll_periods as $previous_payroll)
                        <option value="{{ $previous_payroll->id }}">
                            {{ Carbon\Carbon::parse($previous_payroll->period_start)->format('m/d/Y') }}
                            -
                            {{ Carbon\Carbon::parse($previous_payroll->period_end)->format('m/d/Y') }} 
                            ({{ Carbon\Carbon::parse($previous_payroll->payout_date)->format('m/d/Y') }})
                        </option>
                    @endforeach 
                </x-forms.select>
                @error('payroll_period')
                    <p class="italic text-red-500 text-xs">payroll period is required</p>
                @enderror
            </div>
        </div>
    {{-- end modal body --}}
    {{-- modal footer --}}
        <div class="w-full py-4 flex justify-end space-x-2 border-t border-stone-200">
            <x-forms.button-rounded-md-secondary onclick="modalObject.closeModal('modalTaxContribution')">
                Cancel
            </x-forms.button-rounded-md-secondary>
            <x-forms.button-rounded-md-primary wire:click="generateTaxContributionReport" wire:loading.attr="disabled">
                Generate Report
            </x-forms.button-rounded-md-primary>
        </div>
    {{-- end modal footer --}}
</x-modal-small>
{{--  --}}

{{-- modal total hours --}}
<x-modal-small id="modalNotif" title="Sorry" wire:ignore.self>
    {{-- modal body --}}
        <div class="space-y-4 my-4 h-20 items-center flex justify-center">
            <p class="text-red-500 italic">No data found</p>
        </div>
    {{-- end modal body --}}
    {{-- modal footer --}}
        <div class="w-full py-4 flex justify-end space-x-2 border-t border-stone-200">
            <x-forms.button-rounded-md-secondary onclick="modalObject.closeModal('modalNotif')">
                Cancel
            </x-forms.button-rounded-md-secondary>
        </div>
    {{-- end modal footer --}}
</x-modal-small>
{{--  --}}