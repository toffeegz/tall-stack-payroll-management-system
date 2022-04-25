{{-- modal loan details --}}
<x-modal-small id="modalLoanDetails" title="Loan Details" wire:ignore.self>
    {{-- modal body --}}
    <div class="space-y-4 my-4">

        {{-- status and amount --}}
        <div class=" grid grid-cols-2 gap-4">

            {{-- status --}}
            <div class="">
                <x-forms.label>
                    Status
                </x-forms.label>
                <x-forms.select wire:model="selected_status">
                    <option value="1">Pending</option>
                    <option value="2">Approved</option>
                    <option value="3">Disapproved</option>
                </x-forms.select>
                @error('selected_status')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            {{-- amount --}}
            <div class="">
                <x-forms.label>
                    Amount
                </x-forms.label>
                <x-forms.input type="number" wire:model="selected_amount"></x-forms.input>
                @error('selected_amount')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
            
        </div>

        {{-- install period and installment amount --}}
        <div class=" grid grid-cols-2 gap-4">
            <div class="">
                <x-forms.label>
                    Install Period
                </x-forms.label>
                <x-forms.select wire:model="selected_install_period">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                </x-forms.select>
                @error('selected_install_period')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            {{-- period --}}
            <div class="">
                <x-forms.label>
                    Installment Amount
                </x-forms.label>
                <div class="w-full text-sm rounded-md shadow-sm border border-gray-300 px-3 p-2">
                    ₱ {{ number_format($selected_installment_amount, 2, '.',',')}}
                </div>
                @error('selected_installment_amount')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
        </div>


    </div>
    {{-- end modal body --}}
    {{-- modal footer --}}
    <div class="w-full py-4 flex justify-between border-t border-stone-200">
        <x-forms.button-rounded-md-danger wire:click="deleteLoan">
            Delete
        </x-forms.button-rounded-md-danger>
        <div class="flex justify-end space-x-2">
            <x-forms.button-rounded-md-secondary onclick="modalObject.closeModal('modalLoanDetails')">
                Close
            </x-forms.button-rounded-md-secondary>
            <x-forms.button-rounded-md-primary wire:click="updateLoanDetails" wire:key >
                Update
            </x-forms.button-rounded-md-primary>
        </div>
    </div>
    {{-- end modal footer --}}
</x-modal-small>
{{-- end loan --}}



{{-- modal loan details --}}
<x-modal-small id="modalGrantLoan" title="Grant Loan" wire:ignore.self>
    {{-- modal body --}}
    <div class="space-y-4 my-4">
        <div class="">
            <x-forms.label>
                User
            </x-forms.label>
            <x-forms.select wire:model="new_user_id">
                <option value="">- select user -</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->formal_name() }}</option>
                @endforeach 
            </x-forms.select>
            @error('new_user_id')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        <div class="">
            <x-forms.label>
                Project
            </x-forms.label>
            <x-forms.select wire:model="new_project_id">
                <option value="">- select project -</option>
                @foreach($projects as $project)
                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                @endforeach 
            </x-forms.select>
            @error('new_project_id')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        {{-- status and amount --}}
        <div class=" grid grid-cols-2 gap-4">

            {{-- status --}}
            <div class="">
                <x-forms.label>
                    Status
                </x-forms.label>
                <x-forms.select wire:model="new_status">
                    <option value="1">Pending</option>
                    <option value="2">Approved</option>
                    <option value="3">Disapproved</option>
                </x-forms.select>
                @error('new_status')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            {{-- amount --}}
            <div class="">
                <x-forms.label>
                    Amount
                </x-forms.label>
                <x-forms.input type="number" wire:model="new_amount"></x-forms.input>
                @error('new_amount')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
            
        </div>

        {{-- install period and installment amount --}}
        <div class=" grid grid-cols-2 gap-4">
            <div class="">
                <x-forms.label>
                    Install Period
                </x-forms.label>
                <x-forms.select wire:model="new_install_period">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                </x-forms.select>
                @error('new_install_period')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            {{-- period --}}
            <div class="">
                <x-forms.label>
                    Installment Amount
                </x-forms.label>
                <div class="w-full text-sm rounded-md shadow-sm border border-gray-300 px-3 p-2">
                    ₱ {{ number_format($new_installment_amount, 2, '.',',')}}
                </div>
                @error('new_installment_amount')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="ml-2">
            <x-forms.checkbox wire:model="new_auto_deduct"></x-forms.checkbox>
            <x-forms.checkbox-label>
                Auto Deduct in Payroll
            </x-forms.checkbox-label>
        </div>

        <div>
            <x-forms.label>
                Details
            </x-forms.label>
            <x-forms.textarea wire:model="new_details" rows="2"></x-forms.textarea>
            @error('new_details')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>


    </div>
    {{-- end modal body --}}
    {{-- modal footer --}}
    <div class="w-full py-4 flex justify-end space-x-2 border-t border-stone-200">
        <x-forms.button-rounded-md-secondary onclick="modalObject.closeModal('modalGrantLoan')">
            Close
        </x-forms.button-rounded-md-secondary>
        <x-forms.button-rounded-md-primary wire:click="submitLoan" >
            Submit
        </x-forms.button-rounded-md-primary>
    </div>
    {{-- end modal footer --}}
</x-modal-small>
{{-- end loan --}}