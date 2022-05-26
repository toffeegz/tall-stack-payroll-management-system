<div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
    <div class="space-y-4">

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
                    Suffix
                </x-light-forms.label>
                <x-light-forms.select wire:model.defer="suffix_name">
                    <option value="">- -</option>
                    @foreach(config('company.suffix_name') as $val)
                        <option value="{{ $val }}">{{ $val }}</option>
                    @endforeach 
                </x-light-forms.select>
            </div>
        </div>


        {{-- phone_number, nationality --}}
        <div class="grid grid-cols-2 gap-4">
            {{-- phone_number --}}
            <div class=" space-y-1">
                <x-light-forms.label>
                    Phone Number<span class="text-red-400 ml-1">*</span>
                </x-light-forms.label>
                <x-light-forms.input type="number" wire:model.defer="phone_number"></x-light-forms.input>
                
            </div>
            {{-- email --}}
            <div class="space-y-1">
                <x-light-forms.label>
                    Email<span class="text-red-400 ml-1">*</span>
                </x-light-forms.label>
                <x-light-forms.input type="email" wire:model.defer="email"></x-light-forms.input>
            </div>
        </div>

        {{-- marital_status, gender --}}
        <div class="grid grid-cols-3 gap-4">
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
