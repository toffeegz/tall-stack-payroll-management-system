<div>
    {{-- Because she competes with no one, no one can compete with her. --}}
    <div class="h-full overflow-y-auto">
        <div class="container px-6 mx-auto grid">
            <h2 class="my-6 text-2xl font-semibold text-stone-700">
                Attendance
            </h2>
            <div>
                {{-- Table header --}}
                <div class="flex justify-between my-4 space-x-4">
                    <div class="md:w-72">
                        <x-forms.search-input placeholder="{{ $hide ? 'search date, in, out' : 'search employee name or code'}}" name="search"/>
                    </div>
                    <div class="space-x-2 flex">
                        <x-forms.select wire:model="search_project_id_table">
                            <option value="">- All -</option>
                            <option value="n/a">N/A</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}">{{ $project->name }}</option>
                            @endforeach 
                        </x-forms.select>
                        @if(Auth::user()->hasRole('administrator'))
                        <x-forms.button-rounded-md-success class="whitespace-nowrap" onclick="modalObject.openModal('modalApproveAttendance')">
                            <i class="fa-solid fa-check-double"></i>
                            <span class="hidden md:inline-flex">Approve</span>
                        </x-forms.button-rounded-md-success>
                        @endif
                        <x-forms.button-rounded-md-primary class="whitespace-nowrap" onclick="modalObject.openModal('modalAddAttendance')">
                            <i class="fa-solid fa-plus"></i>
                            <span class="hidden md:inline-flex">Add</span>
                        </x-forms.button-rounded-md-primary>
                    </div>
                </div>

                <!-- New Table -->
                <div class="w-full overflow-hidden rounded-lg shadow-xs">
                    <div class="w-full overflow-x-auto">
                        <table class="w-full whitespace-no-wrap">
                            <thead>
                            <tr class="text-xs font-semibold tracking-wide text-left text-stone-500 uppercase border-b  bg-stone-50 ">
                                @if(Auth::user()->hasRole('administrator') || Auth::user()->hasRole('timekeeper'))
                                <th class="px-4 py-3">User</th>
                                @endif
                                <th class="px-4 py-3">Date</th>
                                <th class="px-4 py-3">In</th>
                                <th class="px-4 py-3">Out</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Project</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y "  >
                                @foreach($attendances as $attendance)
                                <tr class="text-stone-700 cursor-pointer" wire:click="openAttendanceDetails({{ $attendance->id }})" wire:key>
                                    @if(Auth::user()->hasRole('administrator') || Auth::user()->hasRole('timekeeper'))
                                    <td class="px-4 py-3">
                                        <div class="flex items-center text-sm">
                                            <!-- Avatar with inset shadow -->
                                            <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block" >
                                                <img class="object-cover w-full h-full rounded-full"  src="{{ asset('storage/img/users/'. $attendance->profile_photo_path) }}" alt="" loading="lazy" />
                                                <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true" ></div>
                                            </div>
                                            <div>
                                                <p class="font-semibold">{{ $attendance->first_name . " " . $attendance->last_name }}</p>
                                                <p class="text-xs text-stone-600 ">
                                                    {{ $attendance->code }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    @endif
                                    <td class="px-4 py-3 text-sm">
                                        {{ Carbon\Carbon::parse($attendance->date)->format('Y-m-d') }}
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        {{ Carbon\Carbon::parse($attendance->time_in)->format('h:i a') }}
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        {{ Carbon\Carbon::parse($attendance->time_out)->format('h:i a') }}
                                    </td>
                                    <td class="px-4 py-3 text-xs">
                                        @if($attendance->status == 1)
                                            <span class="px-2 py-1 font-semibold text-green-700 bg-green-100 leading-tight bg rounded-full ">
                                                Present
                                            </span>
                                        @elseif($attendance->status == 2)
                                            <span class="px-2 py-1 font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full ">
                                                Late
                                            </span>
                                        @elseif($attendance->status == 3)
                                            <span class="px-2 py-1 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full ">
                                                No sched
                                            </span>
                                        @elseif($attendance->status == 4)
                                            <span class="px-2 py-1 font-semibold leading-tight text-gray-700 bg-gray-100 rounded-full ">
                                                Pending
                                            </span>
                                        @elseif($attendance->status == 5)
                                            <span class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full ">
                                                Disapproved
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        {{ $attendance->project_id ? Helper::getProjectName($attendance->project_id) : 'N/A'}}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                {{ $attendances->links() }}
            </div>
        </div>
    </div>


    
    {{-- MODALS --}}

        @include('scripts.attendance.attendance-component')
        @include('modals.attendance.attendance-component')
</div>




