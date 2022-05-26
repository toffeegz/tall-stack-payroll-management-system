<div>
    {{-- The Master doesn't talk, he acts. --}}
    <div class="h-full overflow-y-auto px-4 md:px-12 mb-10">

        <div class="flex justify-between mb-4 mt-6 ml-12 md:ml-0">
            <p class="text-xl font-bold">
                Add New Employee
            </p>
            <div class="w-fit inline-flex">
                <div class=" items-center mr-2 hidden md:flex">
                    <x-light-forms.label class="whitespace-nowrap">
                        Saved Draft
                    </x-light-forms.label>
                </div>
                <x-light-forms.select wire:model="selected_draft">
                    <option value="">- select draft -</option>
                    @foreach($drafts as $draft)
                        <option value="{{ $draft->id }}">{{ $draft->name }}</option>
                    @endforeach 
                </x-light-forms.select>
            </div>
        </div>

        {{-- users without rate --}}
        @if($errors->any())
            <div class="flex items-center justify-between p-4 mb-8 text-sm font-semibold text-stone-900 bg-red-50 rounded-xl border border-red-100 focus:outline-none focus:shadow-outline-stone">
                <div class="flex flex-row space-x-4 w-full">
                    <div class="flex items-center bg-red-100 rounded-md p-2 h-16">
                        <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 48 48" style=" fill:#f63b3b;"><path d="M 24 4 C 12.972292 4 4 12.972292 4 24 C 4 27.275316 4.8627078 30.334853 6.2617188 33.064453 L 4.09375 40.828125 C 3.5887973 42.631528 5.3719261 44.41261 7.1757812 43.908203 L 14.943359 41.740234 C 17.671046 43.137358 20.726959 44 24 44 C 35.027708 44 44 35.027708 44 24 C 44 12.972292 35.027708 4 24 4 z M 24 7 C 33.406292 7 41 14.593708 41 24 C 41 33.406292 33.406292 41 24 41 C 20.997029 41 18.192258 40.218281 15.744141 38.853516 A 1.50015 1.50015 0 0 0 14.609375 38.71875 L 7.2226562 40.78125 L 9.2851562 33.398438 A 1.50015 1.50015 0 0 0 9.1503906 32.263672 C 7.7836522 29.813476 7 27.004518 7 24 C 7 14.593708 14.593708 7 24 7 z M 23.976562 12.978516 A 1.50015 1.50015 0 0 0 22.5 14.5 L 22.5 26.5 A 1.50015 1.50015 0 1 0 25.5 26.5 L 25.5 14.5 A 1.50015 1.50015 0 0 0 23.976562 12.978516 z M 24 31 A 2 2 0 0 0 24 35 A 2 2 0 0 0 24 31 z"></path></svg>
                    </div>
                    <div class="w-full">
                        <div class="font-bold text-base text-red-600">Oh no! There was an error</div>
                        <div class="text-stone-500 text-xs font-light grid grid-cols-3 w-full">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="space-y-6">
            {{-- personal_information --}}
            <div class="space-y-4">
                <p class="text-sm uppercase font-bold tracking-wide text-stone-700 w-fit px-2 border-b-2 border-red-400">
                    Personal Information
                </p>

                {{-- name --}}
                <div class="grid grid-cols-7 gap-4">

                    {{-- first_name --}}
                    <div class="col-span-7 md:col-span-2 space-y-1">
                        <x-light-forms.label>
                            First Name<span class="text-red-400 ml-1">*</span>
                        </x-light-forms.label>
                        <x-light-forms.input type="text" wire:model.defer="first_name"></x-light-forms.input>
                    </div>

                    {{-- middle_name --}}
                    <div class="col-span-7 md:col-span-2 space-y-1">
                        <x-light-forms.label>
                            Middle Name
                        </x-light-forms.label>
                        <x-light-forms.input type="text" wire:model.defer="middle_name"></x-light-forms.input>
                    </div>

                    {{-- last_name --}}
                    <div class="col-span-7 md:col-span-2 space-y-1">
                        <x-light-forms.label>
                            Last Name<span class="text-red-400 ml-1">*</span>
                        </x-light-forms.label>
                        <x-light-forms.input type="text" wire:model.defer="last_name"></x-light-forms.input>
                    </div>

                    {{-- suffix_name --}}
                    <div class="col-span-7 md:col-span-1 space-y-1">
                        <x-light-forms.label>
                            Suffix<span class="text-red-400 ml-1">*</span>
                        </x-light-forms.label>
                        <x-light-forms.select wire:model.defer="suffix_name">
                            <option value="">- -</option>
                            @foreach(config('company.suffix_name') as $val)
                                <option value="{{ $val }}">{{ $val }}</option>
                            @endforeach 
                        </x-light-forms.select>
                    </div>
                </div>


                {{--  --}}
                <div class="grid grid-cols-2 gap-4">

                    {{-- profile phone_number email code --}}
                    <div class="col-span-2 md:col-span-1 flex space-x-4">
                        
                        {{-- profile --}}
                        <div class="w-5/12">
                            <div>
                                <x-light-forms.label>
                                    Image<small class="text-gray-400 text-xs ml-1">(jpg,png)</small>
                                </x-light-forms.label>
                                <label class="flex flex-col w-full hover:bg-gray-100">
                                    <div class="relative flex flex-col items-center justify-center pt-14 pb-1/4">
                                        <img @if($profile_photo_path) src="{{ $profile_photo_path->temporaryUrl() }}" @endif 
                                        class="absolute rounded-lg w-full h-full object-cover border-dashed border-2 border-gray-100 inset-0">
                                        <i class="far fa-image fa-3x text-gray-300 group-hover:text-gray-400"></i>
                                        <p class="pt-1 text-xs tracking-wider font-semibold text-gray-300 group-hover:text-gray-400">
                                            Select a photo
                                        </p>
                                        <input type="file" class="opacity-0 w-full" accept="image/*" wire:model="profile_photo_path"/>
                                    </div>
                                </label>
                            </div>
                        </div>

                        {{-- email phone code --}}
                        <div class="w-full space-y-4">

                            {{-- email --}}
                            <div class="space-y-1">
                                <x-light-forms.label>
                                    Email<span class="text-red-400 ml-1">*</span>
                                </x-light-forms.label>
                                <x-light-forms.input type="email" wire:model.defer="email"></x-light-forms.input>
                            </div>

                            {{-- phone_number, nationality --}}
                            <div class="grid grid-cols-3 gap-4">
                                {{-- phone_number --}}
                                <div class="col-span-2 space-y-1">
                                    <x-light-forms.label>
                                        Phone Number<span class="text-red-400 ml-1">*</span>
                                    </x-light-forms.label>
                                    <x-light-forms.input type="number" wire:model.defer="phone_number"></x-light-forms.input>
                                    
                                </div>
                                {{-- gender --}}
                                <div class="space-y-1">
                                    <x-light-forms.label>
                                        Gender<span class="text-red-400 ml-1">*</span>
                                    </x-light-forms.label>
                                    <x-light-forms.select wire:model.defer="gender">
                                        <option value="">- -</option>
                                        @foreach(config('company.gender') as $key => $val)
                                            <option value="{{ $key }}">{{ $val }}</option>
                                        @endforeach 
                                    </x-light-forms.select>
                                </div>
                            </div>

                            {{-- marital_status, gender --}}
                            <div class="grid grid-cols-2 gap-4">
                                {{-- marital_status --}}
                                <div class="space-y-1">
                                    <x-light-forms.label>
                                        Marital Status<span class="text-red-400 ml-1">*</span>
                                    </x-light-forms.label>
                                    <x-light-forms.select wire:model.defer="marital_status">
                                        <option value="">- select marital status -</option>
                                        @foreach(config('company.marital_status') as $key => $val)
                                            <option value="{{ $key }}">{{ $val }}</option>
                                        @endforeach 
                                    </x-light-forms.select>
                                </div>
                                {{-- nationality --}}
                                <div class="space-y-1">
                                    <x-light-forms.label>
                                        Nationality<span class="text-red-400 ml-1">*</span>
                                    </x-light-forms.label>
                                    <x-light-forms.input type="text" wire:model.defer="nationality"></x-light-forms.input>
                                    
                                </div>
                                
                            </div>
                        </div>
                    </div>

                    {{-- birth_date, birth_place, fathers_name, mothers_name --}}
                    <div class="col-span-2 md:col-span-1 space-y-4">
                        {{-- birth_date, birth_place --}}
                        <div class="grid grid-cols-5 gap-4">
                            {{-- birth_date --}}
                            <div class="col-span-2 space-y-1">
                                <x-light-forms.label>
                                    Birth Date<span class="text-red-400 ml-1">*</span>
                                </x-light-forms.label>
                                <x-light-forms.input type="date" wire:model.defer="birth_date"></x-light-forms.input>
                            </div>
                            {{-- birth_place --}}
                            <div class="col-span-3 space-y-1">
                                <x-light-forms.label>
                                    Birth Place
                                </x-light-forms.label>
                                <x-light-forms.input type="text" wire:model.defer="birth_place"></x-light-forms.input>
                            </div>
                        </div>
                        <div class="flex space-x-4">
                            {{-- fathers_name, mothers_name --}}
                            <div class="flex-auto grid grid-cols-2 gap-4">
                                {{-- fathers_name --}}
                                <div class="col-span-2 md:col-span-1 space-y-1">
                                    <x-light-forms.label>
                                    Father's Name
                                    </x-light-forms.label>
                                    <x-light-forms.input type="text" wire:model.defer="fathers_name"></x-light-forms.input>
                                    
                                </div>
                                {{-- mothers_name --}}
                                <div class="col-span-2 md:col-span-1 space-y-1">
                                    <x-light-forms.label>
                                        Mother's Name
                                    </x-light-forms.label>
                                    <x-light-forms.input type="text" wire:model.defer="mothers_name"></x-light-forms.input>
                                    
                                </div>
                            </div>
                            <div class="flex-none w-24 space-y-1">
                                <x-light-forms.label>
                                    # Dependent
                                </x-light-forms.label>
                                <x-light-forms.input type="text" wire:model.defer="number_dependent"></x-light-forms.input>
                                
                            </div>
                        </div>
                        {{-- address --}}
                        <div class="space-y-1">
                            <x-light-forms.label>
                                Address
                            </x-light-forms.label>
                            <x-light-forms.input type="text" wire:model.defer="address"></x-light-forms.input>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- employment_details --}}
            <div class="space-y-4">
                <p class="text-sm uppercase font-bold tracking-wide text-stone-700 w-fit px-2 border-b-2 border-red-400">
                    Employment Details
                </p>

                {{-- department --}}
                <div class="flex justify-between">
                    <div class="flex items-center">
                        <x-light-forms.label class="whitespace-nowrap">
                            Choose Job Title<span class="text-red-400 ml-1">*</span>
                        </x-light-forms.label>
                    </div>
                    <div class="w-fit inline-flex">
                        <div class=" items-center mr-2 hidden md:flex">
                            <x-light-forms.label>
                                Department
                            </x-light-forms.label>
                        </div>
                        <x-light-forms.select wire:model="department_id">
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->department_name }}</option>
                            @endforeach 
                        </x-light-forms.select>
                    </div>
                </div>

                {{-- job_title --}}
                <div>
                    <div class="grid grid-cols-4 grid-flow-row-dense gap-4">
                        @foreach($designations as $designation)
                            <div>
                                <input wire:click="selectDesignation({{ $designation->id }})" class="hidden designationradio" id="designation_{{ $designation->id }}" type="radio" name="radio" onclick="selectDesignation({{$designation->id}})">
                                <label class="{{ $selected_designation == $designation->id ? ' border-blue-500 shadow-md' : ''}} h-full flex p-4 border rounded-lg border-gray-300 hover:border-blue-400 shadow-sm cursor-pointer" for="designation_{{ $designation->id }}">
                                    <input wire:model="selected_designation"  onclick="selectDesignation({{$designation->id}})" value="{{ $designation->id }}" disabled name="designation" id="radio_designation_{{ $designation->id }}" type="radio" class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer">

                                    <div class="flex flex-col">
                                        <span class="text-xs font-bold uppercase">{{ $designation->designation_name }}</span>
                                        <span class="text-base font-bold mt-2">₱{{ number_format($designation->daily_rate, 2, '.', '') }}/daily</span>
                                        <span class="text-xs text-stone-500 line-clamp-2">
                                            {{ $designation->details }}
                                        </span>
                                    </div>
                                </label>
                            </div>
                        @endforeach 
                    </div>
                </div>

                <div class="grid grid-cols-12 gap-4">

                    {{-- left panel --}}
                    <div class="col-span-12 md:col-span-5 space-y-4">
                        {{-- employment_status, hired_date --}}
                        <div class=" grid grid-cols-3 gap-4">
                            {{-- employment_status --}}
                            <div class="col-span-3 md:col-span-2 space-y-1">
                                <x-light-forms.label>
                                    Employment Status<span class="text-red-400 ml-1">*</span>
                                </x-light-forms.label>
                                <x-light-forms.select wire:model.defer="employment_status">
                                    <option value="">- -</option>
                                    @foreach(config('company.employment_status') as $key => $val)
                                        <option value="{{ $key }}">{{ $val }}</option>
                                    @endforeach 
                                </x-light-forms.select>
                            </div>
                            {{-- hired_date --}}
                            <div class="col-span-3 md:col-span-1 space-y-1">
                                <x-light-forms.label>
                                    Hired Date<span class="text-red-400 ml-1">*</span>
                                </x-light-forms.label>
                                <x-light-forms.input type="date" wire:model.defer="hired_date"></x-light-forms.input>
                            </div>
                        </div>

                        {{-- frequency, code --}}
                        <div class=" grid grid-cols-5 gap-4">
                            {{-- employment_status --}}
                            <div class="col-span-5 md:col-span-2 space-y-2">
                                <x-light-forms.label>
                                    Frequency<span class="text-red-400 ml-1">*</span>
                                </x-light-forms.label>
                                <div class="space-y-1">
                                    <div class="form-check px-2">
                                        <x-forms.radio-box value="1" wire:model="frequency_id" name="frequency" id="frequency1"></x-forms.radio-box>
                                        <x-light-forms.radio-box-label for="frequency1">
                                            Semi-Monthly
                                        </x-light-forms.radio-box-label>
                                    </div>
                                    <div class="form-check px-2">
                                        <x-forms.radio-box value="2" wire:model="frequency_id" name="frequency" id="frequency2"></x-forms.radio-box>
                                        <x-light-forms.radio-box-label for="frequency2">
                                            Weekly
                                        </x-light-forms.radio-box-label>
                                    </div>
                                </div>
                            </div>
                            {{-- code --}}
                            <div class="col-span-5 md:col-span-3 space-y-1">
                                <x-light-forms.label>
                                    Code
                                </x-light-forms.label>
                                <input type="text" wire:model="code" {{ $auto_generate_code ? 'disabled':'' }} class="w-full text-sm font-semibold rounded-md border-gray-200 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 disabled:bg-stone-100 disabled:text-stone-600">
                                <div class="ml-2 pt-1 flex">
                                    <x-forms.checkbox wire:model="auto_generate_code"></x-forms.checkbox>
                                    
                                    <x-light-forms.radio-box-label>
                                        auto generate code
                                    </x-light-forms.radio-box-label>
                                </div>
                            </div>
                        </div>

                    </div>
                    {{-- right panel --}}
                    <div class="col-span-12 md:col-span-7 space-y-4">

                        <div class="space-y-1">
                            <div class="grid grid-cols-3 gap-4">
                                {{-- sss --}}
                                <div class="col-span-3 md:col-span-1 space-y-1">
                                    <x-light-forms.label>
                                        SSS
                                    </x-light-forms.label>
                                    <x-light-forms.input type="number" wire:model.defer="sss_number"></x-light-forms.input>
                                </div>
                                {{-- hdmf --}}
                                <div class="col-span-3 md:col-span-1 space-y-1">
                                    <x-light-forms.label>
                                        HDMF
                                    </x-light-forms.label>
                                    <x-light-forms.input type="number" wire:model.defer="hdmf_number"></x-light-forms.input>
                                </div>
                                {{-- phic --}}
                                <div class="col-span-3 md:col-span-1 space-y-1">
                                    <x-light-forms.label>
                                        PHIC
                                    </x-light-forms.label>
                                    <x-light-forms.input type="number" wire:model.defer="phic_number"></x-light-forms.input>
                                </div>
                            </div>
                            <div class="ml-2 pt-1 flex">
                                <x-forms.checkbox wire:model.defer="is_tax_exempted"></x-forms.checkbox>
                                <x-light-forms.radio-box-label>
                                    tax exempted
                                </x-light-forms.radio-box-label>
                            </div>
                        </div>

                        <div>
                            <x-light-forms.label>
                                Covered under holiday pay
                            </x-light-forms.label>
                            <div class="ml-2 pt-2 flex">
                                <x-forms.checkbox wire:model.defer="is_paid_holidays"></x-forms.checkbox>
                                <x-light-forms.radio-box-label>
                                    Yes
                                </x-light-forms.radio-box-label>
                            </div>

                    </div>

                </div>

                
            </div>
        </div>

        <div class="flex justify-end space-x-2 ">
            <x-forms.button-rounded-md-secondary wire:click="saveInformations" wire:loading.attr="disabled">
                Save Informations
            </x-forms.button-rounded-md-secondary>
            <x-forms.button-rounded-md-primary wire:click="submit" wire:loading.attr="disabled">
                Proceed
            </x-forms.button-rounded-md-primary>
        </div>

    </div>
    @include('scripts.employee.new-employee-form-script')
    @include('modals.employee.new-employee-form-modal')
    
</div>
