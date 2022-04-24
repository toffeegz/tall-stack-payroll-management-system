<div>
    {{-- The Master doesn't talk, he acts. --}}
    <div class="h-full overflow-y-auto">
        <div class="container px-6 mx-auto grid">
            <h2 class="my-6 text-2xl font-semibold text-stone-700">
                Project
            </h2>
            {{-- body --}}
            <div class=" w-full grid grid-cols-3 gap-4">

                <div class="col-span-3 md:col-span-2 space-y-6">
                    <div>
                        {{-- Table header --}}
                        <div class="flex justify-between my-4 space-x-4">
                            <div class="md:w-72">
                                <x-forms.search-input placeholder="search employee" name="search"/>
                            </div>
                            <div class="space-x-2 flex">
                                @if(count($selected_users_to_remove) != 0)
                                <x-forms.button-rounded-md-danger onclick="modalObject.openModal('modalRemoveUsers')">
                                    <i class="fa-solid fa-trash"></i>
                                    <span class="hidden md:inline-flex">Remove</span>
                                </x-forms.button-rounded-md-danger>
                                @endif
                                <x-forms.button-rounded-md-primary class="whitespace-nowrap" onclick="modalObject.openModal('modalAddUsers')">
                                    <i class="fa-solid fa-plus"></i>
                                    <span class="hidden md:inline-flex">Add Employee</span>
                                </x-forms.button-rounded-md-primary>
                            </div>
                        </div>
        
                        <!-- New Table -->
                        <div class="w-full overflow-hidden rounded-lg shadow-xs">
                            <div class="w-full overflow-x-auto">
                                <table class="w-full whitespace-no-wrap">
                                    <thead>
                                    <tr class="text-xs font-semibold tracking-wide text-left text-stone-500 uppercase border-b  bg-stone-50 ">
                                        
                                        <th class="px-4 py-3">Name</th>
                                        <th class="px-4 py-3">Job Title</th>
                                        <th class="px-4 py-3">Email</th>
                                        <th class="px-4 py-3"></th>
                                        
                                    </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y "  >
                                        @foreach($users as $user)
                                            <tr class="text-stone-700" >
                                                <td class="px-4 py-3">
                                                    <div class="flex items-center text-sm">
                                                        <!-- Avatar with inset shadow -->
                                                        <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block" >
                                                            <img class="object-cover w-full h-full rounded-full"  src="{{ asset('storage/img/users/'. $user->profile_photo_path) }}" alt="" loading="lazy" />
                                                            <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true" ></div>
                                                        </div>
                                                        <div>
                                                            <p class="font-semibold">{{ $user->informal_name() }}</p>
                                                            <p class="text-xs text-stone-600 ">
                                                                {{ $user->code }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-4 py-3 text-xs font-semibold text-stone-700">
                                                    {{ $user->latestDesignation() ? $user->latestDesignation()->designation_name : '' }}
                                                </td>
                                                <td class="px-4 py-3 text-sm">
                                                    {{ $user->email }}
                                                </td>
                                                <td class="px-2 md:px-4 py-3 w-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 align-top bg-no-repeat bg-center bg-contain float-left cursor-pointer" 
                                                        type="checkbox" value="{{ $user->id }}" wire:model="selected_users_to_remove">
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {{ $users->links() }}
                    </div>

                    <a href="#" class="flex items-center justify-between p-4 mb-8 text-sm font-semibold text-stone-900 bg-white rounded-xl border-2 border-stone-100 focus:outline-none focus:shadow-outline-stone">
                        <div class="flex flex-row space-x-4">
                            <div class="flex items-center bg-purple-100 rounded-md p-1">
                                <img src="{{ asset('storage/img/icons/report.png') }}" class="w-10 h-10 object-cover"/>
                            </div>
                            <div class="">
                                <div class="font-bold text-base">
                                    Timekeeper
                                </div>
                                <div class="text-stone-700 text-sm font-light">
                                    @if($current_timekeeper)
                                        Current Timekeeper of the project: <span class="font-semibold">{{ $current_timekeeper->user->formal_name() }}</span>
                                    @else
                                        Assign employee as a timekeeper
                                    @endif
                                </div>
                            </div>
                        </div>
                        @if($current_timekeeper)
                            <button wire:click="removeCurrentTimekeeper" class="cursor-pointer text-red-500 text-xs font-semibold">
                                Remove <i class="fa-solid fa-xmark  ml-2 fa-xs"></i>
                            </button>
                        @else
                            <button onclick="modalObject.openModal('modalAssignTimekeeper')" class="cursor-pointer text-blue-500 text-xs font-semibold">
                                Assign <i class="fa-solid fa-angle-right ml-2 fa-xs"></i>
                            </button>
                        @endif
                        
                    </a>    
                </div>

                {{-- right panel --}}
                <div class="col-span-3 md:col-span-1">

                    
                    <div x-data="{ hoverImage: false }" @mouseover.away = "hoverImage = false" class="relative justify-center pt-12 pb-2/4 border border-stone-200 rounded-md">

                        <img  @mouseover="hoverImage = true" src="{{ asset('storage/img/projects/'.$project->profile_photo_path) }}" alt="{{ $project->code }}"
                        class="absolute rounded-lg w-full h-full object-cover inset-0">
                        <div x-cloak x-show="hoverImage" class="absolute w-full h-full flex justify-end p-4 inset-0 ">
                            <button onclick="modalObject.openModal('modalUpdateImage')" class="cursor-pointer text-indigo-500 text-xs font-semibold rounded-full bg-indigo-100 w-7 h-7 flex items-center justify-center">
                                <i class="fa-solid fa-pen"></i>
                            </button>
                        </div>
                    </div>

                    <div class="p-8 text-left space-y-3">
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <h3 class=" font-bold text-stone-900 text-xl block hover:text-primary " >
                                    {{ $project->name }} 
                                </h3>
                                <button onclick="modalObject.openModal('modalUpdateProject')" class="cursor-pointer text-blue-500 text-xs font-semibold rounded-full bg-blue-100 w-7 h-7 flex items-center justify-center">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                            </div>
                            <div class="flex space-x-2">
                                <p class="text-sm text-stone-500">{{ $project->code }}</p>
                            </div>
                            <div class="flex justify-between space-x-2">
                                <button class="text-xs" wire:click="updateStatus" wire:loading.attr="disabled">
                                    @if($project->status == 1)
                                        <span class="px-2 py-1 font-semibold text-blue-700 bg-blue-100 leading-tight bg rounded-full ">
                                            On-going
                                        </span>
                                    @elseif($project->status == 2)
                                        <span class="px-2 py-1 font-semibold text-green-700 bg-green-100 leading-tight bg rounded-full ">
                                            Finished
                                        </span>
                                    @elseif($project->status == 3)
                                        <span class="px-2 py-1 font-semibold leading-tight text-stone-700 bg-stone-100 rounded-full ">
                                            Upcoming
                                        </span>
                                    @endif
                                </button>
                                <p class="text-xs text-green-500">{{ $project->is_subcontractual == true ? 'Subcontractual' : ''}}</p>
                                
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <span class="text-purple-400">
                                <i class="fa-solid fa-calendar-days"></i>
                            </span>
                            <p class="text-xs text-body-color leading-relaxed">
                                {{ $project->start_date ? Carbon\Carbon::parse($project->start_date)->format('M d, Y') : 'MM/DD/YYYY' }} - {{ $project->end_date ? Carbon\Carbon::parse($project->end_date)->format('M d, Y')  : 'MM/DD/YYYY' }}
                            </p>
                        </div>
                        <div class="flex space-x-2">
                            <span class="text-red-400">
                                <i class="fa-solid fa-map-pin"></i>
                            </span>
                            <p class="text-xs text-body-color leading-relaxed">
                                {{ $project->location }}
                            </p>
                        </div>
                        <div class="flex space-x-2">
                            <span class="text-blue-400">
                                <i class="fa-solid fa-circle-info"></i>
                            </span>
                            <p class="text-xs text-body-color leading-relaxed">
                                {{ $project->details }}
                            </p>
                        </div>
                        <div class="flex justify-end space-x-4 pt-4">
                            <x-forms.button-rounded-md-danger onclick="modalObject.openModal('modalDeleteProject')">
                                Delete
                            </x-forms.button-rounded-md-danger>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    
    {{--  --}}
    @include('scripts.project.project-details-script')
    @include('modals.project.project-details-modal')
</div>
