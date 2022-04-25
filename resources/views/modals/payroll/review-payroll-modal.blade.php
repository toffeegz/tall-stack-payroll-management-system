{{-- modal total hours --}}
    <x-modal-small id="modalEditTaxContributions" title="Tax Contributions ({{ $selected_user_name }})" wire:ignore.self>
        {{-- modal body --}}
            <div class="space-y-4 my-4">
                {{-- total hours --}}
                @if($selected_user_id != null)
                    <div class="w-full">
                        <x-forms.label>
                            SSS
                        </x-forms.label>
                        <x-forms.input type="number" wire:model="sss_amount"></x-forms.input>
                        @error('sss_amount')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="w-full">
                        <x-forms.label>
                            Pag-Ibig
                        </x-forms.label>
                        <x-forms.input type="number" wire:model="hdmf_amount"></x-forms.input>
                        @error('hdmf_amount')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="w-full">
                        <x-forms.label>
                            Philhealth
                        </x-forms.label>
                        <x-forms.input type="number" wire:model="phic_amount"></x-forms.input>
                        @error('phic_amount')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- <div >
                        <p class="font-semibold text-sm text-stone-500">Total Tax Contributions: {{ number_format($total_tax_contributions, 2, '.', ',') }}</p>
                    </div> --}}
                @endif
            </div>
        {{-- end modal body --}}
        {{-- modal footer --}}
            <div class="w-full py-4 flex justify-end space-x-2 border-t border-stone-200">
                <x-forms.button-rounded-md-secondary onclick="modalObject.closeModal('modalEditTaxContributions')">
                    Cancel
                </x-forms.button-rounded-md-secondary>
                <x-forms.button-rounded-md-primary wire:click="submitTaxContributions">
                    Submit
                </x-forms.button-rounded-md-primary>
            </div>
        {{-- end modal footer --}}
    </x-modal-small>
{{--  --}}
