{{-- modal loan details --}}
<x-modal-small id="modalPayLoan" title="Pay Loan" wire:ignore.self>
    {{-- modal body --}}
    <div class="space-y-4 my-4">

        <div class="">
            <x-forms.label>
                User
            </x-forms.label>
            <x-forms.select wire:model="user_id">
                <option value="">- select user -</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->formal_name() }}</option>
                @endforeach 
            </x-forms.select>
            @error('user_id')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>
        
        {{-- date and amount --}}
        <div class=" grid grid-cols-2 gap-4">

            {{-- amount --}}
            <div class="">
                <x-forms.label>
                    Amount
                </x-forms.label>
                <x-forms.input type="number" wire:model="amount"></x-forms.input>
                @error('amount')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
            
            {{-- date --}}
            <div class="">
                <x-forms.label>
                    Date
                </x-forms.label>
                <x-forms.input type="date" wire:model="pay_date"></x-forms.input>
                @error('pay_date')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

        </div>

        <div>
            <x-forms.label>
                Notes
            </x-forms.label>
            <x-forms.textarea wire:model="notes" rows="2"></x-forms.textarea>
            @error('notes')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        {{-- period --}}
        <div class="">
            <x-forms.label>
                Loan Balance
            </x-forms.label>
            <div class="w-full text-sm rounded-md shadow-sm border border-gray-300 px-3 p-2">
                ₱ {{ number_format($loan_balance, 2, '.',',')}}
            </div>
        </div>

    </div>
    {{-- end modal body --}}
    {{-- modal footer --}}
    <div class="w-full py-4 flex justify-end space-x-2 border-t border-stone-200">
        <x-forms.button-rounded-md-secondary onclick="modalObject.closeModal('modalPayLoan')">
            Close
        </x-forms.button-rounded-md-secondary>
        <x-forms.button-rounded-md-primary wire:click="submitPayLoan" >
            Submit
        </x-forms.button-rounded-md-primary>
    </div>
    {{-- end modal footer --}}
</x-modal-small>
{{-- end loan --}}


{{-- modal notif hours --}}
<x-modal-small id="modalNotif" title="Success" wire:ignore.self>
    {{-- modal body --}}
    <div class="text-center p-5 flex-auto justify-center">
        <x-notification.success title="Great!">
            Loan Installment saved successfully
        </x-notification.success>
    </div>
    {{-- end modal body --}}
    {{-- modal footer --}}
    {{-- end modal footer --}}
</x-modal-small>
{{--  --}}