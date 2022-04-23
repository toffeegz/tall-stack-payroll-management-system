{{-- modal loan details --}}
<x-modal-small id="modalLoanRequest" title="Loan Request" wire:ignore.self>
    {{-- modal body --}}
    <div class="space-y-4 my-4">

        <div>
            <x-forms.label>
                Details
            </x-forms.label>
            <x-forms.textarea wire:model="details" rows="2"></x-forms.textarea>
            @error('details')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>


    </div>
    {{-- end modal body --}}
    {{-- modal footer --}}
    <div class="w-full py-4 flex justify-end border-t space-x-2 border-stone-200">
        <x-forms.button-rounded-md-secondary onclick="modalObject.closeModal('modalLoanRequest')">
            Close
        </x-forms.button-rounded-md-secondary>
        <x-forms.button-rounded-md-primary wire:click="requestLoan" wire:key >
            Submit
        </x-forms.button-rounded-md-primary>
    </div>
    {{-- end modal footer --}}
</x-modal-small>
{{-- end loan --}}




{{-- modal loan details --}}
<x-modal-small id="modalCancelLoan" title="Loan Request" wire:ignore.self>
    {{-- modal body --}}
    <div class="space-y-4 my-4">

        <x-notification.delete title="Cancel Request?">
            Are you sure you want to cancel this request?
        </x-notification.delete>



    </div>
    {{-- end modal body --}}
    {{-- modal footer --}}
    <div class="w-full py-4 flex space-x-2 justify-end border-t border-stone-200 px-4">
        <x-forms.button-rounded-md-secondary onclick="modalObject.closeModal('modalCancelLoan')">
            Close
        </x-forms.button-rounded-md-secondary>
        <x-forms.button-rounded-md-danger wire:click="cancelRequest">
            Cancel Request
        </x-forms.button-rounded-md-danger>
    </div>
    {{-- end modal footer --}}
</x-modal-small>
{{-- end loan --}}


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