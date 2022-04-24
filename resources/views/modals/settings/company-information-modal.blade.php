{{-- modal company information --}}
<x-modal-small id="modalEditCompanyInformation" title="Edit Company Information" wire:ignore.self>
    {{-- modal body --}}
    <div class="space-y-4 my-4">

        {{-- image --}}
        <div class="">
            <div class="w-full">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-first-name">
                    Upload <small class="text-gray-400 ml-2">Image(jpg,png)</small>
                </label> 
                <label class="flex flex-col w-full hover:bg-gray-100">
                    <div class="relative flex flex-col items-center justify-center pt-12 pb-1/4">

                        <img @if($logo_path) src="{{ $logo_path->temporaryUrl() }}" @endif 
                        class="absolute rounded-lg w-full h-full object-cover border-dashed border-4 border-gray-100 inset-0">
                        <i class="far fa-image fa-3x text-gray-300 group-hover:text-gray-400"></i>
                        <p class="pt-1 text-sm tracking-wider font-semibold text-gray-300 group-hover:text-gray-400">
                            Select a photo
                        </p>
                        <input type="file" class="opacity-0" accept="image/*" wire:model="logo_path"/>
                    </div>
                </label>
            </div>
            @error('logo_path')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

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

{{-- modal loan details --}}
<x-modal-small id="modalEditDesignation" title="Edit Company Information" wire:ignore.self>
    {{-- modal body --}}
    <div class="space-y-4 my-4">


        {{-- company name --}}
        <div>
            <x-forms.label>
                Designation Name
            </x-forms.label>
            <x-forms.input wire:model="designation_name" type="text"></x-forms.input>
            @error('designation_name')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <x-forms.label>
                Daily Rate
            </x-forms.label>
            <x-forms.input wire:model="daily_rate" type="text"></x-forms.input>
            @error('daily_rate')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>


    </div>
    {{-- end modal body --}}
    {{-- modal footer --}}
    <div class="w-full py-4 flex justify-end space-x-2 border-t border-stone-200">
        <x-forms.button-rounded-md-secondary onclick="modalObject.closeModal('modalEditDesignation')">
            Close
        </x-forms.button-rounded-md-secondary>
        <x-forms.button-rounded-md-primary wire:click="editDesignation" >
            Update
        </x-forms.button-rounded-md-primary>
    </div>
    {{-- end modal footer --}}
</x-modal-small>
{{-- end loan --}}