<div>
    {{-- Because she competes with no one, no one can compete with her. --}}
    <div>
        {{-- Table header --}}
        <div class="flex justify-between my-4 space-x-4">
            <div class="md:w-72">
                <x-forms.search-input placeholder="search employee" name="search"/>
            </div>
            <div class="space-x-2 flex">
                <x-forms.button-rounded-md-secondary class="whitespace-nowrap" wire:click="download">
                    <i class="fa-solid fa-download"></i>
                    <span class="hidden md:inline-flex">Download</span>
                </x-forms.button-rounded-md-secondary>
                <x-forms.button-rounded-md-primary class="whitespace-nowrap" wire:click="hireNewEmployee">
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
                        <th class="px-4 py-3">Phone</th>
                        <th class="px-4 py-3">Status</th>
                        
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y "  >
                        @foreach($users as $user)
                            <tr class="text-stone-700 cursor-pointer"  wire:click="goToProfile({{ $user->id }})">
                                <td class="px-4 py-3">
                                    <div class="flex items-center text-sm">
                                        <!-- Avatar with inset shadow -->
                                        <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block" >
                                            <?php 
                                                $profile = $user->profile_photo_path != null ? $user->profile_photo_path : 'sample.png';
                                            ?>
                                            <img class="object-cover w-full h-full rounded-full"  src="{{ asset('storage/img/users/'. $profile ) }}" alt="" loading="lazy" />
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
                                    {{ $user->latestDesignation() ? $user->latestDesignation()->designation_name : 'N/A' }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $user->email }}
                                </td>
                                <td class="px-4 py-3 text-xs">
                                    {{ $user->phone_number }}
                                </td>
                                <td class="px-4 py-3 text-xs text-center">
                                    @if($user->is_active == true)
                                        <span class="px-2 py-1 font-semibold text-green-700 bg-green-100 leading-tight bg rounded-full ">
                                            Active
                                        </span>
                                    @else
                                        <span class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full ">
                                            Inactive
                                        </span>
                                    @endif
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




