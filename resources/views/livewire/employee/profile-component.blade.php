<div>
    {{-- The Master doesn't talk, he acts. --}}
    <div class="h-full overflow-y-auto px-6 ">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6 mt-6">
            
            {{-- left panel --}}
            <div class="md:col-span-4 space-y-6 md:border-r md:border-r-stone-200 h-screen p-6"> 
                <div clas="">
                    <div class="flex justify-center mb-2">
                        <div class="relative  w-36 h-36 rounded-full block p-1 border border-stone-200" >
                            <img class="object-cover w-full h-full rounded-full"  src="{{ asset('storage/img/users/'. $user->profile_photo_path) }}" alt="" loading="lazy" />
                            <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true" ></div>
                        </div>
                    </div>
                    <div class="tracking-wide mb-6">
                        <div class="text-center text-base font-bold  text-stone-900 ">
                            {{ $user->informal_name() }}
                        </div>
                        <div class="text-center text-sm text-stone-500 font-semibold " >
                            {{ $user->latestDesignation() ? $user->latestDesignation()->designation_name : 'N/A'  }}
                        </div>
                    </div>
                    <div class="space-y-2 mb-4">
                        <div class="flex space-x-4">
                            <i class="fa-solid fa-at text-green-500"></i>
                            <span class="text-sm text-stone-500">{{ $user->email }}</span>
                        </div>
                        <div class="flex space-x-4" >
                            <i class="fa-solid fa-phone text-blue-500"></i>
                            <span class="text-sm text-stone-500">{{ $user->phone_number }}</span>
                        </div>
                    </div>

                    <hr class="my-6">

                    <div clas="">
                        <div class="text-sm mb-4">
                            <div class="text-stone-500 mb-2">Worked Since</div>
                            <div class="text-stone-800 ml-4 font-semibold">{{ Carbon\Carbon::parse($user->hired_date)->format('M, Y') }}</div>
                        </div>
                        <div class="text-sm mb-4">
                            <div class="text-stone-500 mb-2">Total Hours Worked</div>
                            <div class="text-stone-800 ml-4 font-semibold">{{ $total_hours_worked }}hrs</div>
                        </div>
                    </div>

                    <hr class="my-6">

                    <div>
                        <div class="flex justify-between mb-2">
                            <div class="text-sm font-semibold text-stone-500">
                                <i class="fa-solid fa-user-check mr-2"></i>
                                Active
                            </div>
                            @livewire('components.toggle-button', ['model' => $user, 'field' => 'is_active'])
                        </div>
                        <div class="flex justify-between mb-2">
                            <div class="text-sm font-semibold text-stone-500">
                                <i class="fa-solid fa-desktop mr-2"></i>
                                System Access
                            </div>
                            @livewire('components.toggle-button', ['model' => $user, 'field' => 'system_access'])
                        </div>
                        <div class="flex justify-between mb-2">
                            <div class="text-sm font-semibold text-stone-500">
                                <i class="fa-solid fa-box-archive mr-2"></i>
                                Archive
                            </div>
                            <div >
                                {{-- The best athlete wants his opponent at his best. --}}
                                <input wire:model="is_archive" class="form-check-input appearance-none w-9 rounded-full float-left h-5 align-top bg-white bg-no-repeat bg-contain focus:outline-none cursor-pointer shadow-sm" type="checkbox" role="switch" />
                            </div>
                            
                            {{-- @livewire('components.toggle-button', ['model' => $user, 'field' => 'is_archive']) --}}
                        </div>
                    </div>


                </div>

            </div>

            {{-- right panel --}}
            <div class="md:col-span-8 space-y-6"> 
                <div class="py-6 flex space-x-6 text-sm font-bold text-stone-500  tracking-wide">
                    <a wire:click="page('details')" class="{{ $page_name == 'details'? 'border-b-2 border-red-400': '' }} py-1 px-4 cursor-pointer">
                        Details
                    </a>
                    <a wire:click="page('personal_information')" class="{{ $page_name == 'personal_information'? 'border-b-2 border-red-400': '' }} py-1 px-4 cursor-pointer">
                        Personal Information  
                    </a>
                    <a wire:click="page('employment')" class="{{ $page_name == 'employment'? 'border-b-2 border-red-400': '' }} py-1 px-4 cursor-pointer">
                        Employment
                    </a>
                </div>
                <div class="my-6">
            
                    @if($page_name == "details")
                        @livewire('employee.profile.details-component', ['user_id'=> $user->id])
                    @elseif($page_name == "personal_information")
                        @livewire('employee.profile.personal-information-component', ['user_id'=> $user->id])
                    @elseif($page_name == "employment")
                        {{-- @livewire('settings.tax-contribution-component') --}}
                    @endif
                </div>
            </div>

        </div>


    </div>

    {{--  --}}
    @include('scripts.employee.profile-script')
    @include('modals.employee.profile-modal')
</div>
