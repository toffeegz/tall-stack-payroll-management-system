<div>
    {{-- The Master doesn't talk, he acts. --}}
    <div class="h-full overflow-y-auto px-4 md:px-32">

        <div class="flex justify-between mb-4 mt-6 ml-4">
            <p class="text-xl font-bold">
                Add New Employee
            </p>
        </div>

        <div class=" mb-6 space-x-4 bg-white w-full border border-stone-200 shadow-sm rounded-md  p-4 md:p-6">
            
            @if($page == 1)
                {{-- personal information --}}
                <div class="">
                    <div class=" mb-2 ">
                        <p class="text-lg font-bold">
                            Personal Information
                        </p>
                    </div>

                    <div class="space-y-4">

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
                        {{--  --}}

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
                        {{--  --}}

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
                        {{--  --}}
                    </div>

                </div>
            @elseif($page == 2)
                {{-- employment details --}}
                <div class="">
                    <div class=" mb-2 ">
                        <p class="text-lg font-bold">
                            Employment Details
                        </p>
                    </div>

                    <div class="space-y-4 grid grid-cols-2 gap-4">
                        <div class="col-span-2 md:col-span-1">
                            <div class="space-y-4">
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
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="">
                                        <x-forms.label>
                                            Hired Date
                                        </x-forms.label>
                                        <x-forms.input type="date" wire:model="hired_date"></x-forms.input>
                                        @error('hired_date')
                                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="">
                                        <x-forms.label>
                                            Frequency
                                        </x-forms.label>
                                        <x-forms.select wire:model="frequency_id">
                                            <option value="1">Semi-Monthly</option>
                                            <option value="2">Weekly</option>
                                        </x-forms.select>
                                        @error('frequency_id')
                                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                
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
                
                                <div class="flex justify-between">
                                    <div class="space-y-2 w-full">
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
                                    <div class="flex items-center justify-center w-full">
                                        <p class="text-stone-700 text-sm font-bold">Daily Rate: ₱{{ number_format($daily_rate, 2, '.', ',') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- image --}}
                        <div class="col-span-2 md:col-span-1">
                            <div class="w-full">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-first-name">
                                    Upload <small class="text-gray-400 ml-2">Image(jpg,png)</small>
                                </label> 
                                <label class="flex flex-col w-full hover:bg-gray-100">
                                    <div class="relative flex flex-col items-center justify-center pt-12 pb-1/4">

                                        <img @if($profile_photo_path) src="{{ $profile_photo_path->temporaryUrl() }}" @endif 
                                        class="absolute rounded-lg w-full h-full object-cover border-dashed border-4 border-gray-100 inset-0">
                                        <i class="far fa-image fa-3x text-gray-300 group-hover:text-gray-400"></i>
                                        <p class="pt-1 text-sm tracking-wider font-semibold text-gray-300 group-hover:text-gray-400">
                                            Select a photo
                                        </p>
                                        <input type="file" class="opacity-0" accept="image/*" wire:model="profile_photo_path"/>
                                    </div>
                                </label>
                            </div>
                            @error('profile_photo_path')
                                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

            @else 

            @endif

            
            {{--  --}}
            <div class="flex justify-between mt-8">
                <div>
                @if($page > 1)
                    <button wire:click="backPage" wire:loading.attr="disabled" class="px-4 py-1.5 text-xs font-semibold leading-5 text-white transition-colors duration-150 bg-stone-500 border border-transparent rounded-full active:bg-stone-600 hover:bg-stone-600 focus:outline-none focus:shadow-outline-purple">
                        <i class="ml-2 fa-solid fa-arrow-left-long"></i>
                        Back
                    </button>
                @endif
                </div>
                <button wire:click="nextPage" wire:loading.attr="disabled" class="px-4 py-1.5 text-xs font-semibold leading-5 text-white transition-colors duration-150 bg-blue-500 border border-transparent rounded-full active:bg-blue-600 hover:bg-blue-600 focus:outline-none focus:shadow-outline-purple">
                    Proceed
                    {{-- wire:click="nextPage" --}}
                    <i class="ml-2 fa-solid fa-arrow-right-long"></i>
                </button>
            </div>
        </div>


    </div>
    @include('scripts.employee.new-employee-form-script')
    @include('modals.employee.new-employee-form-modal')
    
</div>
