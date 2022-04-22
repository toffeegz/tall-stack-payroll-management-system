{{-- modal personal information --}}
<x-modal-large id="modalPersonalInformation" title="Personal Information" wire:ignore.self>
    {{-- modal body --}}
        <div class="space-y-4 my-4">

            {{-- full name --}}
            <div class="grid grid-cols-3 gap-4">

                {{-- last name --}}
                <div class="">
                    <x-forms.label>
                        Last Name
                    </x-forms.label>
                    <x-forms.input type="text" wire:model="last_name"></x-forms.input>
                    @error('last_name')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                {{-- first name --}}
                <div class="">
                    <x-forms.label>
                        First Name
                    </x-forms.label>
                    <x-forms.input type="text" wire:model="first_name"></x-forms.input>
                    @error('first_name')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                {{-- middle name --}}
                <div class="">
                    <x-forms.label>
                        Middle Name
                    </x-forms.label>
                    <x-forms.input type="text" wire:model="middle_name"></x-forms.input>
                    @error('middle_name')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{--  --}}
            <div class="grid grid-cols-3 gap-4">

                {{-- ID --}}
                <div class="">
                    <x-forms.label>
                        ID
                    </x-forms.label>
                    <x-forms.input type="text" wire:model="code"></x-forms.input>
                    @error('code')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                {{-- email --}}
                <div class="">
                    <x-forms.label>
                        Email
                    </x-forms.label>
                    <x-forms.input type="email" wire:model="email"></x-forms.input>
                    @error('email')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                {{-- phone number --}}
                <div class="">
                    <x-forms.label>
                        Phone Number
                    </x-forms.label>
                    <x-forms.input type="number" wire:model="phone_number"></x-forms.input>
                    @error('phone_number')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{--  --}}
            <div class="grid grid-cols-4 gap-4">

                {{-- gender --}}
                <div class="">
                    <x-forms.label>
                        Gender
                    </x-forms.label>
                    <x-forms.select wire:model="gender">
                        <option value="">- select gender-</option>
                        @foreach(config('company.gender') as $key => $val)
                            <option value="{{ $key }}">{{ $val }}</option>
                        @endforeach 
                    </x-forms.select>
                    @error('gender')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                {{-- marital_status --}}
                <div class="">
                    <x-forms.label>
                        Marital Status
                    </x-forms.label>
                    <x-forms.select wire:model="marital_status">
                        <option value="">- select marital status -</option>
                        @foreach(config('company.marital_status') as $key => $val)
                            <option value="{{ $key }}">{{ $val }}</option>
                        @endforeach 
                    </x-forms.select>
                    @error('marital_status')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                {{-- birth_date --}}
                <div class="">
                    <x-forms.label>
                        Birth Date
                    </x-forms.label>
                    <x-forms.input type="date" wire:model="birth_date"></x-forms.input>
                    @error('birth_date')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                {{-- nationality --}}
                <div class="">
                    <x-forms.label>
                        Nationality
                    </x-forms.label>
                    <x-forms.input type="text" wire:model="nationality"></x-forms.input>
                    @error('nationality')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- full name --}}
            <div class="grid grid-cols-2 gap-4">

                {{-- fathers_name --}}
                <div class="">
                    <x-forms.label>
                        Father's Name
                    </x-forms.label>
                    <x-forms.input type="text" wire:model="fathers_name"></x-forms.input>
                    @error('fathers_name')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                {{-- mother_name --}}
                <div class="">
                    <x-forms.label>
                        Mother's Name
                    </x-forms.label>
                    <x-forms.input type="text" wire:model="mothers_name"></x-forms.input>
                    @error('mothers_name')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- full name --}}
            <div class="">
                <x-forms.label>
                    Address
                </x-forms.label>
                <x-forms.textarea type="text" wire:model="address" rows="2"></x-forms.textarea>
                @error('address')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

        </div>
    {{-- end modal body --}}
    {{-- modal footer --}}
        <div class="w-full py-4 flex justify-end space-x-2 border-t border-stone-200">
            <x-forms.button-rounded-md-secondary onclick="modalObject.closeModal('modalPersonalInformation')">
                Cancel
            </x-forms.button-rounded-md-secondary>
            <x-forms.button-rounded-md-primary wire:click="submitPersonalInformation" wire:loading.attr="disabled">
                Update
            </x-forms.button-rounded-md-primary>
        </div>
    {{-- end modal footer --}}
</x-modal-large>
{{--  --}}


{{-- modal employment details --}}
<x-modal-small id="modalEmploymentDetails" title="Employment Details" wire:ignore.self>
    {{-- modal body --}}
        <div class="space-y-4 my-4">
            <div class="grid grid-cols-2 gap-4">
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

                {{-- active --}}
                <div class="ml-4">
                    <x-forms.checkbox wire:model="is_active"></x-forms.checkbox>
                    <x-forms.checkbox-label>
                        Active
                    </x-forms.checkbox-label>
                </div>
            </div>
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


{{-- modal compensation --}}
<x-modal-small id="modalCompensation" title="Compensation" wire:ignore.self>
    {{-- modal body --}}
        <div class="space-y-4 my-4">
            {{--  --}}
            <div class="grid grid-cols-2 gap-4">

                {{-- department --}}
                <div class="">
                    <x-forms.label>
                        Department
                    </x-forms.label>
                    <x-forms.select wire:model="department_id">
                        <option value="">- select department-</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->department_name }}</option>
                        @endforeach 
                    </x-forms.select>
                    @error('department_id')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                {{-- designation --}}
                <div class="">
                    <x-forms.label>
                        Job Title
                    </x-forms.label>
                    <x-forms.select wire:model="designation_id">
                        <option value="">- select job title-</option>
                        @foreach($designations as $designation)
                            <option value="{{ $designation->id }}">{{ $designation->designation_name }}</option>
                        @endforeach 
                    </x-forms.select>
                    @error('designation_id')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            {{--  --}}
            <div class="grid grid-cols-2 gap-4">
                <div class="ml-2">
                    <x-forms.checkbox wire:model="is_tax_exempted"></x-forms.checkbox>
                    <x-forms.checkbox-label>
                        Tax Exempted
                    </x-forms.checkbox-label>
                </div>
                <div class="ml-2">
                    <x-forms.checkbox wire:model="is_paid_holidays"></x-forms.checkbox>
                    <x-forms.checkbox-label>
                        Paid Holidays
                    </x-forms.checkbox-label>
                </div>
            </div>
        </div>
    {{-- end modal body --}}
    {{-- modal footer --}}
        <div class="w-full py-4 flex justify-end space-x-2 border-t border-stone-200">
            <x-forms.button-rounded-md-secondary onclick="modalObject.closeModal('modalCompensation')">
                Cancel
            </x-forms.button-rounded-md-secondary>
            <x-forms.button-rounded-md-primary wire:click="submitCompensation" wire:loading.attr="disabled">
                Update
            </x-forms.button-rounded-md-primary>
        </div>
    {{-- end modal footer --}}
</x-modal-small>
{{--  --}}