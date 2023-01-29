<div>
    {{-- Because she competes with no one, no one can compete with her. --}}
    <div class="h-full">
        <div class="container px-6 mx-auto grid">
            <h2 class="my-6 text-2xl font-semibold text-stone-700 pl-12 md:pl-0">
                Attendance
            </h2>
            <div>
                {{-- BULK INSERTION --}}
                @if(auth()->user()->hasRole('administrator'))
                    <div class="p-4 mb-8 text-sm font-semibold text-stone-900 bg-white rounded-xl border border-stone-200">
                        <div class="flex items-center justify-between ">
                            <div>
                                <div class="flex flex-row space-x-4">
                                    <div class="flex items-center bg-blue-100 rounded-md h-fit w-fit p-2">
                                        <svg class="w-5 h-5" style=" fill: #3b82f6;"xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"viewBox="0 0 48 48"><path d="M 12.5 4 C 10.032499 4 8 6.0324991 8 8.5 L 8 39.5 C 8 41.967501 10.032499 44 12.5 44 L 35.5 44 C 37.967501 44 40 41.967501 40 39.5 L 40 18.5 A 1.50015 1.50015 0 0 0 39.560547 17.439453 L 39.544922 17.423828 L 26.560547 4.4394531 A 1.50015 1.50015 0 0 0 25.5 4 L 12.5 4 z M 12.5 7 L 24 7 L 24 15.5 C 24 17.967501 26.032499 20 28.5 20 L 37 20 L 37 39.5 C 37 40.346499 36.346499 41 35.5 41 L 12.5 41 C 11.653501 41 11 40.346499 11 39.5 L 11 8.5 C 11 7.6535009 11.653501 7 12.5 7 z M 27 9.1210938 L 34.878906 17 L 28.5 17 C 27.653501 17 27 16.346499 27 15.5 L 27 9.1210938 z M 17.5 25 A 1.50015 1.50015 0 1 0 17.5 28 L 30.5 28 A 1.50015 1.50015 0 1 0 30.5 25 L 17.5 25 z M 17.5 32 A 1.50015 1.50015 0 1 0 17.5 35 L 26.5 35 A 1.50015 1.50015 0 1 0 26.5 32 L 17.5 32 z"></path></svg>
                                    </div>
                                    <div>
                                        <div class="font-bold text-base">
                                            Dry Run Import
                                        </div>
                                        <div class="text-stone-500 text-sm font-light">Process this file will create, update, and ignore:</div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col md:flex-row">
                                <x-forms.button-rounded-md-secondary class="whitespace-nowrap mx-2 mb-2" wire:click="downloadTemplate">
                                    Download Template
                                </x-forms.button-rounded-md-secondary>
                                <x-forms.button-rounded-md-secondary class="whitespace-nowrap mx-2 mb-2" onclick="modalObject.openModal('modalImportAttendance')">
                                    Import File
                                </x-forms.button-rounded-md-secondary>
                            </div>
                        </div>
                        @if($show_excel_results == true)
                            <div class="flex my-4 justify-between">
                                <div class="flex space-x-2 font-bold">
                                    <a wire:click="importPage('create')" class="border-b-2 cursor-pointer {{ $import_page == 'create' ? 'border-red-300 text-stone-600':'border-transparent text-stone-300' }} px-2 py-0.5 flex items-end">
                                        create <span class="text-blue-500 text-xs ml-1">({{ count($import_create) }})</span>
                                    </a>
                                    <a wire:click="importPage('update')" class="border-b-2 cursor-pointer {{ $import_page == 'update' ? 'border-red-300 text-stone-600':'border-transparent text-stone-300' }} px-2 py-0.5 flex items-end">
                                        update <span class="text-blue-500 text-xs ml-1">({{ count($import_update) }})</span>
                                    </p>
                                    <a wire:click="importPage('ignore')" class="border-b-2 cursor-pointer {{ $import_page == 'ignore' ? 'border-red-300 text-stone-600':'border-transparent text-stone-300' }} px-2 py-0.5 flex items-end">
                                        ignore <span class="text-blue-500 text-xs ml-1">({{ count($import_ignore) }})</span>
                                    </a> 
                                </div>
                                <x-forms.button-rounded-md-primary class="whitespace-nowrap mx-2 mb-2" wire:click="submitImport">
                                    Submit
                                </x-forms.button-rounded-md-primary>
                            </div>

                            {{-- table --}}
                            @if($import_page == 'create')
                                <div class="w-full rounded-lg shadow-xs">
                                    <div class="md:w-full md:max-w-full max-w-sm overflow-x-auto">
                                        <table class="w-full whitespace-no-wrap">
                                            <thead>
                                            <tr class="text-xs font-semibold tracking-wide text-left text-stone-500 uppercase border-b  bg-stone-50 ">
                                                <th class="px-4 py-2">Line #</th>
                                                <th class="px-4 py-2">Employee ID</th>
                                                <th class="px-4 py-2">Date</th>
                                                <th class="px-4 py-2">Time In</th>
                                                <th class="px-4 py-2">Time Out</th>
                                                <th class="px-4 py-2">Project Code</th>
                                            </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y "  >
                                                @foreach($import_create as $key => $value)
                                                <tr class="text-stone-700 text-xs">
                                                    <td class="px-4 py-1">
                                                        {{ $key }}
                                                    </td>
                                                    <td class="px-4 py-1 whitespace-nowrap">
                                                        {{ $value['employee_id'] }}
                                                    </td>
                                                    <td class="px-4 py-1">
                                                        {{ $value['date'] }}
                                                    </td>
                                                    <td class="px-4 py-1">
                                                        {{ $value['time_in'] }}
                                                    </td>
                                                    <td class="px-4 py-1">
                                                        {{ $value['time_out'] }}
                                                    </td>
                                                    <td class="px-4 py-1">
                                                        <span class="whitespace-nowrap">{{ $value['project_code'] }}</span>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @elseif($import_page == 'update')
                                <div class="w-full rounded-lg shadow-xs">
                                    <div class="md:w-full md:max-w-full max-w-sm overflow-x-auto">
                                        <table class="w-full whitespace-no-wrap">
                                            <thead>
                                            <tr class="text-xs font-semibold tracking-wide text-left text-stone-500 uppercase border-b  bg-stone-50 ">
                                                <th class="px-4 py-2">Line #</th>
                                                <th class="px-4 py-2">Employee ID</th>
                                                <th class="px-4 py-2">Date</th>
                                                <th class="px-4 py-2">Time In</th>
                                                <th class="px-4 py-2">Time Out</th>
                                                <th class="px-4 py-2">Project Code</th>
                                            </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y "  >
                                                @foreach($import_update as $key => $value)
                                                <tr class="text-stone-700 text-xs">
                                                    <td class="px-4 py-1">
                                                        {{ $key }}
                                                    </td>
                                                    <td class="px-4 py-1 whitespace-nowrap">
                                                        {{ $value['employee_id'] }}
                                                    </td>
                                                    <td class="px-4 py-1">
                                                        {{ $value['date'] }}
                                                    </td>
                                                    <td class="px-4 py-1">
                                                        {{ $value['time_in'] }}
                                                    </td>
                                                    <td class="px-4 py-1">
                                                        {{ $value['time_out'] }}
                                                    </td>
                                                    <td class="px-4 py-1">
                                                        <span class="whitespace-nowrap">{{ $value['project_code'] }}</span>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @elseif($import_page == 'ignore')
                                <div class="w-full rounded-lg shadow-xs">
                                    <div class="md:w-full md:max-w-full max-w-sm overflow-x-auto">
                                        <table class="w-full whitespace-no-wrap">
                                            <thead>
                                            <tr class="text-xs font-semibold tracking-wide text-left text-stone-500 uppercase border-b  bg-stone-50 ">
                                                <th class="px-4 py-2">Line #</th>
                                                <th class="px-4 py-2">Employee ID</th>
                                                <th class="px-4 py-2">Date</th>
                                                <th class="px-4 py-2">Time In</th>
                                                <th class="px-4 py-2">Time Out</th>
                                                <th class="px-4 py-2">Project Code</th>
                                                <th class="px-4 py-2">Details</th>
                                            </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y "  >
                                                @foreach($import_ignore as $key => $value)
                                                <tr class="text-stone-700 text-xs">
                                                    <td class="px-4 py-1">
                                                        {{ $key }}
                                                    </td>
                                                    <td class="px-4 py-1 whitespace-nowrap">
                                                        {{ $value['employee_id'] }}
                                                    </td>
                                                    <td class="px-4 py-1">
                                                        {{ $value['date'] }}
                                                    </td>
                                                    <td class="px-4 py-1">
                                                        {{ $value['time_in'] }}
                                                    </td>
                                                    <td class="px-4 py-1">
                                                        {{ $value['time_out'] }}
                                                    </td>
                                                    <td class="px-4 py-1">
                                                        <span class="whitespace-nowrap">{{ $value['project_code'] }}</span>
                                                    </td>
                                                    <td x-data="{ open: false }" class="px-4 py-1 cursor-pointer" :class="{ 'line-clamp-none': open, 'line-clamp-1': !open }">
                                                        <a x-on:click="open = !open">
                                                            @foreach($value['status'] as $status)
                                                                <span class="whitespace-nowrap">:{{ $status }}</span> <br>
                                                            @endforeach
                                                        </a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif
                            
                        @endif
                    </div>
                @endif
                {{-- Table header --}}
                <div class="md:flex md:justify-between">
                    <div class="md:w-72 pb-4">
                        <x-forms.search-input placeholder="{{ $hide ? 'search date, in, out' : 'search employee name or code'}}" name="search"/>
                    </div>
                    <div class="space-x-2 flex pb-4">
                        <x-forms.select wire:model="search_project_id_table">
                            <option value="">- All -</option>
                            <option value="n/a">N/A</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}">{{ $project->name }}</option>
                            @endforeach 
                        </x-forms.select>
                        @if(Auth::user()->hasRole('administrator'))
                        <x-forms.button-rounded-md-success class="whitespace-nowrap py-3" onclick="modalObject.openModal('modalApproveAttendance')">
                            <i class="fa-solid fa-check-double"></i>
                            <span class="hidden md:inline-flex">
                                Approve
                            </span>
                        </x-forms.button-rounded-md-success>
                        @endif
                        <x-forms.button-rounded-md-secondary class="whitespace-nowrap py-3" wire:click="download">
                            <i class="fa-solid fa-download"></i>
                            <span class="hidden md:inline-flex">
                                Download
                            </span>
                        </x-forms.button-rounded-md-secondary>
                        <x-forms.button-rounded-md-primary class="whitespace-nowrap py-3" onclick="modalObject.openModal('modalAddAttendance')">
                            <i class="fa-solid fa-plus"></i>
                            <span class="hidden md:inline-flex">
                                Add
                            </span>
                        </x-forms.button-rounded-md-primary>
                    </div>
                </div>

                <!-- New Table -->
                <div class="w-full overflow-hidden rounded-lg shadow-xs mb-10">
                    <div class="w-full overflow-x-auto">
                        <table class="w-full whitespace-no-wrap">
                            <thead>
                            <tr class="text-xs font-semibold tracking-wide text-left text-stone-500 uppercase border-b  bg-stone-50 ">
                                @if(Auth::user()->hasRole('administrator') || Auth::user()->hasRole('timekeeper'))
                                <th class="md:px-4 px-2 py-3">User</th>
                                @endif
                                <th class="md:px-4 px-2 py-3">Date</th>
                                <th class="md:px-4 px-2 py-3">In</th>
                                <th class="md:px-4 px-2 py-3">Out</th>
                                <th class="md:px-4 px-2 py-3">Status</th>
                                <th class="md:px-4 px-2 py-3 hidden md:table-cell">Project</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y "  >
                                @foreach($attendances as $attendance)
                                <tr class="text-stone-700 cursor-pointer" wire:click="openAttendanceDetails({{ $attendance->id }})" wire:key>
                                    @if(Auth::user()->hasRole('administrator') || Auth::user()->hasRole('timekeeper'))
                                    <td class="md:px-4 px-2 py-3">
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
                                    <td class="md:px-4 px-2 py-3 text-xs md:text-sm">
                                        {{ Carbon\Carbon::parse($attendance->date)->format('Y-m-d') }}
                                    </td>
                                    <td class="md:px-4 px-2 py-3 text-xs md:text-sm">
                                        {{ Carbon\Carbon::parse($attendance->time_in)->format('h:ia') }}
                                    </td>
                                    <td class="md:px-4 px-2 py-3 text-xs md:text-sm">
                                        {{ Carbon\Carbon::parse($attendance->time_out)->format('h:ia') }}
                                    </td>
                                    <td class="md:px-4 px-2 py-3 text-xs">
                                        @if($attendance->status == 1)
                                            <span class="px-2 py-1 whitespace-nowrap font-semibold text-green-700 bg-green-100 leading-tight bg rounded-full ">
                                                Present
                                            </span>
                                        @elseif($attendance->status == 2)
                                            <span class="px-2 py-1 whitespace-nowrap font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full ">
                                                Late
                                            </span>
                                        @elseif($attendance->status == 3)
                                            <span class="px-2 py-1 whitespace-nowrap font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full ">
                                                No sched
                                            </span>
                                        @elseif($attendance->status == 4)
                                            <span class="px-2 py-1 whitespace-nowrap font-semibold leading-tight text-gray-700 bg-gray-100 rounded-full ">
                                                Pending
                                            </span>
                                        @elseif($attendance->status == 5)
                                            <span class="px-2 py-1 whitespace-nowrap font-semibold leading-tight text-red-700 bg-red-100 rounded-full ">
                                                Disapproved
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-sm hidden md:table-cell">
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




