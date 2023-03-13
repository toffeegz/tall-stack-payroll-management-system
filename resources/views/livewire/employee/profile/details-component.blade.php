<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
    <div class="space-y-6 mb-10">
        {{-- ongoing projects --}}
        <div class="">
            <div class="w-full flex mb-2">
                <div class="flex-none text-stone-500 text-sm font-bold tracking-wide">
                    Ongoing Projects
                </div>
                <hr class="text-stone-500 flex-auto my-2 mx-2">
            </div>
            <div class="w-full grid grid-flow-row-dense grid-cols-1 md:grid-cols-2 gap-4">
                @if($ongoing_projects->count() == 0)
                <div class="text-stone-900 text-sm font-semibold">
                    No ongoing projects
                </div>
                @endif
                @foreach($ongoing_projects as $ongoing_project)
                    <div class="col-span-1 rounded-xl bg-white hover:shadow-lg hover:shadow-stone-200 border border-stone-200">
                        <div class="block h-fit py-2">
                            <div class="flex justify-between">
                                <div class="flex items-center text-sm">
                                    <span class="h-12 w-0.5 mr-3 bg-blue-500"></span>
                                    <!-- Avatar with inset shadow -->
                                    <div class="relative w-8 h-8 mr-3 rounded-full block" >
                                        <img class="object-cover w-full h-full rounded-full"  src="{{ asset('storage/img/projects/'. $ongoing_project->profile_photo_path ) }}" alt="" loading="lazy" />
                                        <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true" ></div>
                                    </div>
                                    <div>
                                        <p class="font-semibold">{{ $ongoing_project->name }}</p>
                                        <p class="text-xs text-stone-600 ">
                                            {{ $ongoing_project->code }}
                                        </p>
                                    </div>
                                </div>
                                <div class="text-xs text-stone-400 px-2 flex items-center">
                                    <i class="fa-solid fa-clock mr-2"></i>
                                    {{ Carbon\Carbon::parse($ongoing_project->created_at)->format('F d, Y') }}
                                </div>
                            </div>
                        </div>
                        <div class="block h-fit border-t border-stone-100">
                            <div class="py-4 px-8 flex justify-between space-x-4">
                                <div class="">
                                    <div class="uppercase text-stone-900 font-bold text-sm block text-center">{{ $ongoing_project->start_date ? Carbon\Carbon::parse($ongoing_project->start_date)->format('F'): 'N/A' }}</div>
                                    <div class="uppercase text-stone-900 font-extrabold text-3xl block text-center tracking-wide">{{ $ongoing_project->start_date ? Carbon\Carbon::parse($ongoing_project->start_date)->format('d') : 'N/A' }}</div>
                                    <div class="capitalize text-stone-400 font-extrabold text-sm block text-center tracking-wider">{{ $ongoing_project->start_date ? Carbon\Carbon::parse($ongoing_project->start_date)->format('D') : 'N/A' }}</div>
                                </div>
                                <div class="">
                                    <div class="block text-blue-500 text-center">
                                        <i class="fa-solid fa-ellipsis fa-2x"></i>
                                        <i class="fa-solid fa-arrow-right-long fa-2x"></i>
                                    </div>
                                    <div class="block text-stone-500 text-xs text-center lowercase">
                                        {{-- {{ $upcoming_project->hours_duration }}hrs {{ $leave->leaveType->name }} --}}
                                    </div>
                                </div>
                                <div class="">
                                    <div class="uppercase text-stone-900 font-bold text-sm block text-center">{{ $ongoing_project->end_date ? Carbon\Carbon::parse($ongoing_project->end_date)->format('F'): 'N/A' }}</div>
                                    <div class="uppercase text-stone-900 font-extrabold text-3xl block text-center tracking-wide">{{ $ongoing_project->end_date ? Carbon\Carbon::parse($ongoing_project->end_date)->format('d') : 'N/A' }}</div>
                                    <div class="capitalize text-stone-400 font-extrabold text-sm block text-center tracking-wider">{{ $ongoing_project->end_date ? Carbon\Carbon::parse($ongoing_project->end_date)->format('D') : 'N/A' }}</div>
                                </div>
                            </div>
                            <div class="bg-stone-100 py-4 px-8">
                                <p class="line-clamp-4 text-left text-stone-500 text-xs">
                                    {{ $ongoing_project->details }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        {{-- upcoming projects --}}
        <div class="">
            <div class="w-full flex mb-2">
                <div class="flex-none text-stone-500 text-sm font-bold tracking-wide">
                    Upcoming Projects
                </div>
                <hr class="text-stone-500 flex-auto my-2 mx-2">
            </div>
            <div class="w-full grid grid-flow-row-dense grid-cols-1 md:grid-cols-2 gap-4">
                @if($upcoming_projects->count() == 0)
                <div class="text-stone-900 text-sm font-semibold">
                    No upcoming projects
                </div>
                @endif
                @foreach($upcoming_projects as $upcoming_project)
                    <div class="col-span-1 rounded-xl bg-white hover:shadow-lg hover:shadow-stone-200 border border-stone-200">
                        <div class="block h-fit py-2">
                            <div class="flex justify-between">
                                <div class="flex items-center text-sm">
                                    <span class="h-12 w-0.5 mr-3 bg-gray-500"></span>
                                    <!-- Avatar with inset shadow -->
                                    <div class="relative w-8 h-8 mr-3 rounded-full block" >
                                        <img class="object-cover w-full h-full rounded-full"  src="{{ asset('storage/img/projects/'. $upcoming_project->profile_photo_path ) }}" alt="" loading="lazy" />
                                        <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true" ></div>
                                    </div>
                                    <div>
                                        <p class="font-semibold">{{ $upcoming_project->name }}</p>
                                        <p class="text-xs text-stone-600 ">
                                            {{ $upcoming_project->code }}
                                        </p>
                                    </div>
                                </div>
                                <div class="text-xs text-stone-400 px-2 flex items-center">
                                    <i class="fa-solid fa-clock mr-2"></i>
                                    {{ Carbon\Carbon::parse($upcoming_project->created_at)->format('F d, Y') }}
                                </div>
                            </div>
                        </div>
                        <div class="block h-fit border-t border-stone-100">
                            <div class="py-4 px-8 flex justify-between space-x-4">
                                <div class="">
                                    <div class="uppercase text-stone-900 font-bold text-sm block text-center">{{ $upcoming_project->start_date ? Carbon\Carbon::parse($upcoming_project->start_date)->format('F'): 'N/A' }}</div>
                                    <div class="uppercase text-stone-900 font-extrabold text-3xl block text-center tracking-wide">{{ $upcoming_project->start_date ? Carbon\Carbon::parse($upcoming_project->start_date)->format('d') : 'N/A' }}</div>
                                    <div class="capitalize text-stone-400 font-extrabold text-sm block text-center tracking-wider">{{ $upcoming_project->start_date ? Carbon\Carbon::parse($upcoming_project->start_date)->format('D') : 'N/A' }}</div>
                                </div>
                                <div class="">
                                    <div class="block text-gray-500 text-center">
                                        <i class="fa-solid fa-ellipsis fa-2x"></i>
                                        <i class="fa-solid fa-arrow-right-long fa-2x"></i>
                                    </div>
                                    <div class="block text-stone-500 text-xs text-center lowercase">
                                        {{-- {{ $upcoming_project->hours_duration }}hrs {{ $leave->leaveType->name }} --}}
                                    </div>
                                </div>
                                <div class="">
                                    <div class="uppercase text-stone-900 font-bold text-sm block text-center">{{ $upcoming_project->end_date ? Carbon\Carbon::parse($upcoming_project->end_date)->format('F'): 'N/A' }}</div>
                                    <div class="uppercase text-stone-900 font-extrabold text-3xl block text-center tracking-wide">{{ $upcoming_project->end_date ? Carbon\Carbon::parse($upcoming_project->end_date)->format('d') : 'N/A' }}</div>
                                    <div class="capitalize text-stone-400 font-extrabold text-sm block text-center tracking-wider">{{ $upcoming_project->end_date ? Carbon\Carbon::parse($upcoming_project->end_date)->format('D') : 'N/A' }}</div>
                                </div>
                            </div>
                            <div class="bg-stone-100 py-4 px-8">
                                <p class="line-clamp-4 text-left text-stone-500 text-xs">
                                    {{ $upcoming_project->details }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        {{-- completed projects --}}
        <div class="">
            <div class="w-full flex mb-2">
                <div class="flex-none text-stone-500 text-sm font-bold tracking-wide">
                    Completed Projects
                </div>
                <hr class="text-stone-500 flex-auto my-2 mx-2">
            </div>
            <div class="w-full grid grid-flow-row-dense grid-cols-1 md:grid-cols-2 gap-4">
                @if($completed_projects->count() == 0)
                <div class="text-stone-900 text-sm font-semibold">
                    No completed projects
                </div>
                @endif
                @foreach($completed_projects as $completed_project)
                    <div class="col-span-1 rounded-xl bg-white hover:shadow-lg hover:shadow-stone-200 border border-stone-200">
                        <div class="block h-fit py-2">
                            <div class="flex justify-between">
                                <div class="flex items-center text-sm">
                                    <span class="h-12 w-0.5 mr-3 bg-green-500"></span>
                                    <!-- Avatar with inset shadow -->
                                    <div class="relative w-8 h-8 mr-3 rounded-full block" >
                                        <img class="object-cover w-full h-full rounded-full"  src="{{ asset('storage/img/projects/'. $completed_project->profile_photo_path ) }}" alt="" loading="lazy" />
                                        <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true" ></div>
                                    </div>
                                    <div>
                                        <p class="font-semibold">{{ $completed_project->name }}</p>
                                        <p class="text-xs text-stone-600 ">
                                            {{ $completed_project->code }}
                                        </p>
                                    </div>
                                </div>
                                <div class="text-xs text-stone-400 px-2 flex items-center">
                                    <i class="fa-solid fa-clock mr-2"></i>
                                    {{ Carbon\Carbon::parse($completed_project->created_at)->format('F d, Y') }}
                                </div>
                            </div>
                        </div>
                        <div class="block h-fit border-t border-stone-100">
                            <div class="py-4 px-8 flex justify-between space-x-4">
                                <div class="">
                                    <div class="uppercase text-stone-900 font-bold text-sm block text-center">{{ $completed_project->start_date ? Carbon\Carbon::parse($completed_project->start_date)->format('F'): 'N/A' }}</div>
                                    <div class="uppercase text-stone-900 font-extrabold text-3xl block text-center tracking-wide">{{ $completed_project->start_date ? Carbon\Carbon::parse($completed_project->start_date)->format('d') : 'N/A' }}</div>
                                    <div class="capitalize text-stone-400 font-extrabold text-sm block text-center tracking-wider">{{ $completed_project->start_date ? Carbon\Carbon::parse($completed_project->start_date)->format('D') : 'N/A' }}</div>
                                </div>
                                <div class="">
                                    <div class="block text-green-500 text-center">
                                        <i class="fa-solid fa-ellipsis fa-2x"></i>
                                        <i class="fa-solid fa-arrow-right-long fa-2x"></i>
                                    </div>
                                    <div class="block text-stone-500 text-xs text-center lowercase">
                                        {{-- {{ $upcoming_project->hours_duration }}hrs {{ $leave->leaveType->name }} --}}
                                    </div>
                                </div>
                                <div class="">
                                    <div class="uppercase text-stone-900 font-bold text-sm block text-center">{{ $completed_project->end_date ? Carbon\Carbon::parse($completed_project->end_date)->format('F'): 'N/A' }}</div>
                                    <div class="uppercase text-stone-900 font-extrabold text-3xl block text-center tracking-wide">{{ $completed_project->end_date ? Carbon\Carbon::parse($completed_project->end_date)->format('d') : 'N/A' }}</div>
                                    <div class="capitalize text-stone-400 font-extrabold text-sm block text-center tracking-wider">{{ $completed_project->end_date ? Carbon\Carbon::parse($completed_project->end_date)->format('D') : 'N/A' }}</div>
                                </div>
                            </div>
                            <div class="bg-stone-100 py-4 px-8">
                                <p class="line-clamp-4 text-left text-stone-500 text-xs">
                                    {{ $completed_project->details }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
