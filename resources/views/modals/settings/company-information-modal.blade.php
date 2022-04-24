{{-- modal loan details --}}
<x-modal-small id="modalEditCompanyInformation" title="Edit Company Information" wire:ignore.self>
    {{-- modal body --}}
    <div class="space-y-4 my-4">

        {{-- company name --}}
        <div>
            <x-forms.label>
                Name
            </x-forms.label>
            <x-forms.input wire:model="name" type="text"></x-forms.input>
            @error('name')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        {{-- email phone --}}
        <div class="grid grid-cols-2 gap-4">
            {{-- email --}}
            <div>
                <x-forms.label>
                    Email
                </x-forms.label>
                <x-forms.input wire:model="email" type="email"></x-forms.input>
                @error('email')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
            {{-- phone --}}
            <div>
                <x-forms.label>
                    Phone Number
                </x-forms.label>
                <x-forms.input wire:model="phone" type="text"></x-forms.input>
                @error('phone')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- address --}}
        <div>
            <x-forms.label>
                Address
            </x-forms.label>
            <x-forms.textarea wire:model="address" rows="2"></x-forms.textarea>
            @error('address')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>


    </div>
    {{-- end modal body --}}
    {{-- modal footer --}}
    <div class="w-full py-4 flex justify-end space-x-2 border-t border-stone-200">
        <x-forms.button-rounded-md-secondary onclick="modalObject.closeModal('modalEditCompanyInformation')">
            Close
        </x-forms.button-rounded-md-secondary>
        <x-forms.button-rounded-md-primary wire:click="editCompanyInformation" >
            Update
        </x-forms.button-rounded-md-primary>
    </div>
    {{-- end modal footer --}}
</x-modal-small>
{{-- end loan --}}