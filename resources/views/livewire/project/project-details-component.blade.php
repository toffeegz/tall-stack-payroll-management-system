<div>
    {{-- The Master doesn't talk, he acts. --}}
    <div class="h-full overflow-y-auto">
        <div class="container px-6 mx-auto grid">
            <h2 class="my-6 text-2xl font-semibold text-stone-700">
                Project
            </h2>
            {{-- body --}}
            <div class=" w-full grid grid-cols-3 gap-4">

                <div class="col-span-3 md:col-span-2">
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
                </div>

                {{-- right panel --}}
                <div class="col-span-3 md:col-span-1">

                </div>

            </div>
        </div>
    </div>

    {{--  --}}
    @include('scripts.project.project-details-script')
    @include('modals.project.project-details-modal')
</div>
