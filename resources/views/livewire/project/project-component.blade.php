<div>
    {{-- Because she competes with no one, no one can compete with her. --}}
    <div class="h-full overflow-y-auto">
        <div class="container px-6 mx-auto grid">
            <h2 class="my-6 text-2xl font-semibold text-stone-700">
                Project
            </h2>
            <div>
                {{-- Table header --}}
                <div class="flex justify-between my-4 space-x-4">
                    <div class="md:w-72">
                        <x-forms.search-input placeholder="search name or code" name="search"/>
                    </div>
                    <div class="space-x-2 flex">
                        <x-forms.button-rounded-md-primary class="whitespace-nowrap" onclick="modalObject.openModal('modalNewProject')">
                            <i class="fa-solid fa-plus"></i>
                            <span class="hidden md:inline-flex">New Project</span>
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
                                <th class="px-4 py-3 whitespace-nowrap">Start Date</th>
                                <th class="px-4 py-3 whitespace-nowrap">End Date</th>
                                <th class="px-4 py-3 text-center">Deployed</th>
                                <th class="px-4 py-3 text-center">Status</th>
                                <th class="px-4 py-3">Location</th>
                                
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y "  >
                                @foreach($projects as $project)
                                    <tr class="text-stone-700 cursor-pointer"  wire:click="openProject({{ $project->id }})">
                                        <td class="px-4 py-3">
                                            <div class="flex items-center text-sm">
                                                <!-- Avatar with inset shadow -->
                                                <div class="relative hidden w-12 h-12 mr-3 rounded-full md:block" >
                                                    <img class="object-cover w-full h-full rounded-full"  src="{{ asset('storage/img/projects/'. $project->profile_photo_path) }}" alt="" loading="lazy" />
                                                    <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true" ></div>
                                                </div>
                                                <div>
                                                    <p class="font-semibold whitespace-nowrap">{{ $project->name }}</p>
                                                    <p class="text-xs text-stone-600 whitespace-nowrap">
                                                        {{ $project->code }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-xs whitespace-nowrap">
                                            {{ $project->start_date ? Carbon\Carbon::parse($project->start_date)->format('M d, Y') : '-' }}
                                        </td>
                                        <td class="px-4 py-3 text-xs whitespace-nowrap">
                                            {{ $project->end_date ? Carbon\Carbon::parse($project->end_date)->format('M d, Y') : '-' }}
                                        </td>
                                        <td class="py-3 px-6 text-center">
                                            <div class="flex items-center justify-center w-28">
                                                @foreach($project->usersImage(4) as $user)
                                                <img class="w-8 h-8 object-cover rounded-full border-gray-200 border -m-1"  src="{{ asset('storage/img/users/'. $user->profile_photo_path) }}"/>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-xs text-center whitespace-nowrap">
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
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            <p class=" line-clamp-3">{{ $project->location }}</p>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                {{ $projects->links() }}
            </div>

            
        </div>
    </div>


    @include('scripts.project.project-script')
    @include('modals.project.project-modal')
</div>




