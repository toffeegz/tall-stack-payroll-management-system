<div>
    {{-- Because she competes with no one, no one can compete with her. --}}
    <div class="h-full">
        <div class="container px-6 mx-auto grid">
            <h2 class="my-6 text-2xl font-semibold text-stone-700 pl-12 md:pl-0">
                Attendance
            </h2>
            <div>
                {{-- Table header --}}
                <div class="md:flex md:justify-between">
                    <div class="md:w-72 pb-4">
                        <x-forms.search-input placeholder="{{ $hide ? 'search date, in, out' : 'search employee name or code'}}" name="search"/>
                    </div>
                    <div class="space-x-2 flex pb-4">
                        @if(\Auth::user()->projects->count() > 0)
                            <x-forms.select wire:model="search_project_id_table">
                                <option value="">- All -</option>
                                <option value="n/a">N/A</option>
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                                @endforeach 
                            </x-forms.select>
                        @endif
                        <x-forms.button-rounded-md-secondary class="whitespace-nowrap py-3" wire:click="download">
                            <i class="fa-solid fa-download"></i>
                            <span class="hidden md:inline-flex">
                                Download
                            </span>
                        </x-forms.button-rounded-md-secondary>
                        @php
                            $showButton = ($todays_attendance === null || $todays_attendance->time_out === null);
                            $buttonLabel = ($todays_attendance !== null && $todays_attendance->time_out === null) ? 'Time Out' : 'Time In';
                            $useLivewireClick = ($projects === null || count($projects) === 0);
                        @endphp

                        @if ($useLivewireClick)
                            @if($showButton)
                            <x-forms.button-rounded-md-primary class="whitespace-nowrap py-3" wire:click="create">
                                <i class="fa-solid fa-plus"></i>
                                <span class="hidden md:inline-flex">
                                    {{ $buttonLabel }}
                                </span>
                            </x-forms.button-rounded-md-primary>
                            @endif
                        @else
                            @if($showButton)
                            <x-forms.button-rounded-md-primary class="whitespace-nowrap py-3" onclick="modalObject.openModal('modalAddAttendance')"  >
                                <i class="fa-solid fa-plus"></i>
                                <span class="hidden md:inline-flex">
                                    {{ $buttonLabel }}
                                </span>
                            </x-forms.button-rounded-md-primary>
                            @endif
                        @endif

                    </div>
                </div>

                <!-- New Table -->
                <div class="w-full overflow-hidden rounded-lg shadow-xs mb-10">
                    <div class="w-full overflow-x-auto">
                        <table class="w-full whitespace-no-wrap">
                            <thead>
                            <tr class="text-xs font-semibold tracking-wide text-left text-stone-500 uppercase border-b  bg-stone-50 ">
                                <th class="md:px-4 px-2 py-3">Date</th>
                                <th class="md:px-4 px-2 py-3">In</th>
                                <th class="md:px-4 px-2 py-3">Out</th>
                                <th class="md:px-4 px-2 py-3">Status</th>
                                @if(\Auth::user()->projects->count() > 0)
                                    <th class="md:px-4 px-2 py-3 hidden md:table-cell">Project</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y "  >
                                @foreach($data as $attendance)
                                <tr class="text-stone-700">
                                    <td class="md:px-4 px-2 py-3 text-xs md:text-sm">
                                        {{ Carbon\Carbon::parse($attendance->date)->format('Y-m-d') }}
                                    </td>
                                    <td class="md:px-4 px-2 py-3 text-xs md:text-sm">
                                        {{ $attendance->time_in }}
                                    </td>
                                    <td class="md:px-4 px-2 py-3 text-xs md:text-sm">
                                        {{ $attendance->time_out }}
                                    </td>
                                    <td class="md:px-4 px-2 py-3 text-xs">
                                        @php
                                            $attendanceStatuses = config('company.attendance_status');
                                        @endphp

                                        @foreach($attendanceStatuses as $key => $status)
                                            @if($attendance->status == $key)
                                                <span class="px-2 py-1 whitespace-nowrap font-semibold leading-tight text-{{ \Helper::getStatusTextColor($key) }} bg-{{ \Helper::getStatusBgColor($key) }} rounded-full">
                                                    {{ $status }}
                                                </span>
                                            @endif
                                        @endforeach
                                    </td>
                                    @if(\Auth::user()->projects->count() > 0)
                                        <td class="px-4 py-3 text-sm hidden md:table-cell">
                                            {{ $attendance->project_id ? Helper::getProjectName($attendance->project_id) : 'N/A'}}
                                        </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                {{ $data->links() }}
            </div>
        </div>
    </div>


    
    {{-- MODALS --}}

        @include('scripts.attendance.attendance-component')
        @include('modals.attendance.employee-attendance-component')
</div>




